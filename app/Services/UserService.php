<?php

namespace App\Services;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Resources\UserResource;
use App\Interfaces\UserServiceInterface;
use App\Models\Role;
use App\Models\User;

class UserService implements UserServiceInterface
{
    /**
     * @return UserResource[]
     * @throws StorageException
     */
    public function getList(): array
    {
        try {
            $result = [];
            foreach (User::all() as $user) {
                $result[] = new UserResource(
                    $user->id,
                    $user->role_id,
                    $user->name
                );
            }
            return $result;
        } catch (\Exception $e) {
            throw new StorageException('Cannot get users from storage');
        }
    }

    /**
     * @param int $id
     * @return ?UserResource
     * @throws StorageException
     */
    public function getById(int $id): ?UserResource
    {
        try {
            if ($user = User::find($id)) {
                return new UserResource(
                    $user->id,
                    $user->role_id,
                    $user->name
                );
            }
        } catch (\Exception $e) {
            throw new StorageException('Cannot get user by ID');
        }

        return null;
    }

    /**
     * @param string $apiKey
     * @return ?UserResource
     * @throws StorageException
     */
    public function getByApiKey(string $apiKey): ?UserResource
    {
        try {
            if ($user = User::whereApiKey($apiKey)->first()) {
                return new UserResource(
                    $user->id,
                    $user->role_id,
                    $user->name
                );
            }
        } catch (\Exception $e) {
            throw new StorageException('Cannot get user by API Key');
        }

        return null;
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @return bool
     * @throws UserException|StorageException
     */
    public function assignGroup(int $userId, int $groupId): bool
    {
        // Check if connection exists
        try {
            $assigned = User::whereHas('groups', function ($query) use ($groupId) {
                $query->where('groups.id', $groupId);
            })->find($userId);
        } catch (\Exception $e) {
            throw new StorageException('Cannot check groups of user');
        }

        if ($assigned) {
            throw new UserException('Group already assigned');
        }

        // Get user
        $user = User::find($userId);
        if (empty($user->id)) {
            throw new UserException('User not found');
        }

        // Assign a group to a user
        try {
            $user->groups()->attach($groupId);
            return true;
        } catch (\Exception $e) {
            throw new StorageException('Cannot assign a group to a user');
        }
    }

    /**
     * @param int $userId
     * @param int $groupId
     * @return bool
     * @throws UserException|StorageException
     */
    public function revokeGroup(int $userId, int $groupId): bool
    {
        // Check if connection exists
        try {
            $user = User::whereHas('groups', function ($query) use ($groupId) {
                $query->where('groups.id', $groupId);
            })->find($userId);
        } catch (\Exception $e) {
            throw new StorageException('Cannot check groups of user');
        }

        if (!$user) {
            throw new UserException('Connection does not exist');
        }

        // Remove a user from a group
        try {
            $user->groups()->detach($groupId);
            return true;
        } catch (\Exception $e) {
            throw new StorageException('Cannot remove a user from a group');
        }
    }

    /**
     * @param string $name
     * @param int $roleId
     * @return UserResource
     * @throws UserException|StorageException
     */
    public function create(string $name, int $roleId): UserResource
    {
        // Check name
        $name = trim($name);
        if (empty($name)) {
            throw new UserException('Invalid user name');
        }

        // Check role
        try {
            $role = Role::find($roleId);
        } catch (\Exception $e) {
            throw new StorageException('Cannot check role');
        }

        if (empty($role->id)) {
            throw new UserException('Role does not exist');
        }

        // Check if a user already exists
        try {
            $existingUser = User::where(['name' => $name])->first();
        } catch (\Exception $e) {
            throw new StorageException('Cannot check existing user');
        }

        if (!empty($existingUser)) {
            throw new UserException('User already exists');
        }

        // Save a new user
        try {
            $user = new User();
            $user->name = $name;
            $user->role_id = $role->id;
            $user->save();

            return new UserResource(
                $user->id,
                $user->role_id,
                $user->name
            );
        } catch (\Exception $e) {
            throw new StorageException('Cannot create a new user');
        }
    }

    /**
     * @param int $id
     * @return int
     * @throws StorageException
     */
    public function delete(int $id): int
    {
        try {
            // Get a user
            $user = User::find($id);

            // Delete relations
            $user->groups()->detach();

            // Delete a user
            return $user->delete();
        } catch (\Exception $e) {
            throw new StorageException('Cannot delete a user: '.$e->getMessage());
        }
    }
}
