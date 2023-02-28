<?php

namespace App\Interfaces;

use App\Exceptions\GroupException;
use App\Exceptions\StorageException;
use App\Http\Resources\GroupResource;

interface GroupServiceInterface
{
    /**
     * @return GroupResource[]
     * @throws StorageException
     */
    public function getList(): array;

    /**
     * @param int $id
     * @return GroupResource[]
     * @throws StorageException
     */
    public function getListByUserId(int $id): array;

    /**
     * @param int $id
     * @return ?GroupResource
     * @throws StorageException
     */
    public function getById(int $id): ?GroupResource;

    /**
     * @param string $name
     * @return GroupResource
     * @throws GroupException|StorageException
     */
    public function create(string $name): GroupResource;

    /**
     * @param int $id
     * @return int
     * @throws GroupException|StorageException
     */
    public function delete(int $id): int;
}
