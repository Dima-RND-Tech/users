<?php

namespace App\Interfaces;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Resources\UserResource;

interface UserServiceInterface
{
    /**
     * @return UserResource[]
     * @throws StorageException
     */
    public function getList(): array;

    /**
     * @param int $id
     * @return ?UserResource
     * @throws StorageException
     */
    public function getById(int $id): ?UserResource;

    /**
     * @param string $apiKey
     * @return ?UserResource
     * @throws StorageException
     */
    public function getByApiKey(string $apiKey): ?UserResource;

    /**
     * @param int $userId
     * @param int $groupId
     * @return bool
     * @throws UserException|StorageException
     */
    public function assignGroup(int $userId, int $groupId): bool;

    /**
     * @param int $userId
     * @param int $groupId
     * @return bool
     * @throws UserException|StorageException
     */
    public function revokeGroup(int $userId, int $groupId): bool;

    /**
     * @param string $name
     * @param int $roleId
     * @return UserResource
     * @throws StorageException
     */
    public function create(string $name, int $roleId): UserResource;

    /**
     * @param int $id
     * @return int
     * @throws UserException|StorageException
     */
    public function delete(int $id): int;
}
