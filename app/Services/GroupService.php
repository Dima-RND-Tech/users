<?php

namespace App\Services;

use App\Exceptions\GroupException;
use App\Exceptions\StorageException;
use App\Http\Resources\GroupResource;
use App\Interfaces\GroupServiceInterface;
use App\Models\Group;
use App\Models\User;

class GroupService implements GroupServiceInterface
{
    /**
     * @return GroupResource[]
     * @throws StorageException
     */
    public function getList(): array
    {
        try {
            $result = [];
            foreach (Group::all() as $group) {
                $result[] = new GroupResource(
                    $group->id,
                    $group->name
                );
            }
            return $result;
        } catch (\Exception $e) {
            throw new StorageException('Cannot get groups from storage');
        }
    }

    /**
     * @param int $id
     * @return GroupResource[]
     * @throws StorageException
     */
    public function getListByUserId(int $id): array
    {
        try {
            $result = [];
            foreach (Group::whereHas('users', function ($query) use ($id) {
                $query->where('users.id', $id);
            })->get() as $group) {
                $result[] = new GroupResource(
                    $group->id,
                    $group->name
                );
            }
            return $result;
        } catch (\Exception $e) {
            throw new StorageException('Cannot get groups by user ID from storage');
        }
    }

    /**
     * @param int $id
     * @return ?GroupResource
     * @throws StorageException
     */
    public function getById(int $id): ?GroupResource
    {
        try {
            if ($group = Group::find($id)) {
                return new GroupResource(
                    $group->id,
                    $group->name
                );
            }
        } catch (\Exception $e) {
            throw new StorageException('Cannot get group by ID');
        }

        return null;
    }

    /**
     * @param string $name
     * @return GroupResource
     * @throws GroupException|StorageException
     */
    public function create(string $name): GroupResource
    {
        // Check name
        $name = trim($name);
        if (empty($name)) {
            throw new GroupException('Invalid group name');
        }

        // Check if a group already exists
        try {
            $existingGroup = Group::where(['name' => $name])->first();
        } catch (\Exception $e) {
            throw new StorageException('Cannot check existing group');
        }

        if (!empty($existingGroup)) {
            throw new GroupException('Group already exists');
        }

        // Save a new group
        try {
            $group = new Group();
            $group->name = $name;
            $group->save();

            return new GroupResource(
                $group->id,
                $group->name
            );

        } catch (\Exception $e) {
            throw new StorageException('Cannot create a new group');
        }
    }

    /**
     * @param int $id
     * @return int
     * @throws GroupException|StorageException
     */
    public function delete(int $id): int
    {
        // Check assigned users
        try {
            $assignedUsers = User::whereHas('groups', function ($query) use ($id) {
                $query->where('groups.id', $id);
            })->get()?->all();
        } catch (\Exception $e) {
            throw new StorageException('Cannot check assigned users');
        }

        if (!empty($assignedUsers)) {
            throw new GroupException('Group has assigned users');
        }

        // Delete group
        try {
            return Group::destroy($id);
        } catch (\Exception $e) {
            throw new StorageException('Cannot delete a group');
        }
    }
}
