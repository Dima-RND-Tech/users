<?php

namespace App\Services;

use App\Exceptions\StorageException;
use App\Http\Resources\RoleResource;
use App\Interfaces\RoleServiceInterface;
use App\Models\Role;

class RoleService implements RoleServiceInterface
{
    /**
     * @param int $id
     * @param string $operation
     * @return bool
     * @throws StorageException
     */
    public function isOperationPermitted(int $id, string $operation): bool
    {
        try {
            return !empty(Role::whereId($id)
                ->whereHas('permissions', function ($query) use ($operation) {
                    $query->where('name', $operation);
                })
                ->first());
        } catch (\Exception $e) {
            throw new StorageException('Cannot check permission: ' . $e->getMessage());
        }
    }

    /**
     * @return RoleResource[]
     * @throws StorageException
     */
    public function getList(): array
    {
        try {
            $items = [];

            foreach (Role::all() as $role) {
                  $items[] = new RoleResource(
                      $role->id,
                      $role->name
                  );
            }

            return $items;
        } catch (\Exception $e) {
            throw new StorageException('Cannot get roles from storage');
        }
    }
}
