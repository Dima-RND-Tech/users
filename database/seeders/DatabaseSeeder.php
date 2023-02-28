<?php

namespace Database\Seeders;

use App\Interfaces\RoleServiceInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            // Create admin role
            $adminRoleId = DB::table('roles')->insertGetId([
                'name' => 'Administrator'
            ]);

            $userRoleId = DB::table('roles')->insertGetId([
                'name' => 'User'
            ]);

            $guestRoleId = DB::table('roles')->insertGetId([
                'name' => 'Guest'
            ]);

            // Create default admin user
            $adminUserId = DB::table('users')->insertGetId([
                'name' => 'admin',
                'role_id' => $adminRoleId,
                'api_key' => env('API_KEY_DEFAULT')
            ]);

            // Create default user
            $userUserId = DB::table('users')->insertGetId([
                'name' => 'user',
                'role_id' => $userRoleId,
            ]);

            // Adding groups
            foreach (['Europe', 'Developers'] as $groupName) {
                $groupId = DB::table('groups')->insertGetId([
                    'name' => $groupName
                ]);

                DB::table('group_user')->insert([
                    [
                        'user_id' => $adminUserId,
                        'group_id' => $groupId
                    ],
                    [
                        'user_id' => $userUserId,
                        'group_id' => $groupId
                    ]
                ]);
            }

            // Add permissions
            foreach ([
                         RoleServiceInterface::PERMISSION_USERS_CREATE,
                         RoleServiceInterface::PERMISSION_USERS_UPDATE,
                         RoleServiceInterface::PERMISSION_USERS_DELETE,
                         RoleServiceInterface::PERMISSION_USERS_GET,
                         RoleServiceInterface::PERMISSION_USERS_LIST,

                         RoleServiceInterface::PERMISSION_USERS_GROUPS_LIST,
                         RoleServiceInterface::PERMISSION_USERS_GROUPS_CREATE,
                         RoleServiceInterface::PERMISSION_USERS_GROUPS_DELETE,

                         RoleServiceInterface::PERMISSION_GROUPS_CREATE,
                         RoleServiceInterface::PERMISSION_GROUPS_DELETE,
                         RoleServiceInterface::PERMISSION_GROUPS_UPDATE,
                         RoleServiceInterface::PERMISSION_GROUPS_GET,
                         RoleServiceInterface::PERMISSION_GROUPS_LIST,

                         RoleServiceInterface::PERMISSION_ROLES_LIST,

                     ] as $permissionName) {

                // Create permission
                $permissionId = DB::table('permissions')->insertGetId([
                    'name' => $permissionName
                ]);

                // Add all permissions to admins
                DB::table('permission_role')->insert([
                    'permission_id' => $permissionId,
                    'role_id' => $adminRoleId,
                ]);
            }

        } catch (\Exception $e) {
            // Data exists
        }
    }
}
