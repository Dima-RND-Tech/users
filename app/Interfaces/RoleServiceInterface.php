<?php

namespace App\Interfaces;

use App\Exceptions\StorageException;
use App\Exceptions\RoleException;
use App\Http\Resources\RoleResource;

interface RoleServiceInterface
{
    public const PERMISSION_USERS_CREATE = 'users.create';
    public const PERMISSION_USERS_UPDATE = 'users.update';
    public const PERMISSION_USERS_DELETE = 'users.delete';
    public const PERMISSION_USERS_GET = 'users.get';
    public const PERMISSION_USERS_LIST = 'users.list';

    public const PERMISSION_USERS_GROUPS_LIST = 'users.groups.list';
    public const PERMISSION_USERS_GROUPS_CREATE = 'users.groups.create';
    public const PERMISSION_USERS_GROUPS_DELETE = 'users.groups.delete';

    public const PERMISSION_GROUPS_CREATE = 'groups.create';
    public const PERMISSION_GROUPS_UPDATE = 'groups.update';
    public const PERMISSION_GROUPS_DELETE = 'groups.delete';
    public const PERMISSION_GROUPS_GET = 'groups.get';
    public const PERMISSION_GROUPS_LIST = 'groups.list';

    public const PERMISSION_ROLES_LIST = 'roles.list';

    /**
     * @param int $id
     * @param string $operation
     * @return bool
     * @throws StorageException
     */
    public function isOperationPermitted(int $id, string $operation): bool;

    /**
     * @return RoleResource[]
     * @throws StorageException
     */
    public function getList(): array;
}
