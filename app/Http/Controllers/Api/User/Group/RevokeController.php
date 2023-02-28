<?php

namespace App\Http\Controllers\Api\User\Group;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class RevokeController extends AbstractController
{
    /**
     * @OA\Delete(
     *      path="/users/{userId}/groups/{groupId}/revoke",
     *      operationId="UsersGroupsRevoke",
     *      summary="Removes a user from a group",
     *      description="This API Endpoint removes users from groups.",
     *      tags={"Users"},
     *
     *     @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          example="1",
     *
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\Parameter(
     *          name="groupId",
     *          in="path",
     *          description="Group ID",
     *          required=true,
     *          example="1",
     *
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=204,
     *          description="Revoked",
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *
     *     @OA\Response(
     *          response=405,
     *          description="Method Not Allowed"
     *      ),
     *
     *     @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *     )
     * )
     */
    public function index(Request $request, string $userId, string $groupId): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_GROUPS_DELETE);

            // Check parameters
            $userId = intval($userId);
            $groupId = intval($groupId);

            if (empty($userId) || empty($groupId)) {
                return $this->responseBadRequest();
            }

            // Check if a group exists
            $group = $this->groupService->getById($groupId);
            if (!$group) {
                return $this->responseNotFound('Group Not Found');
            }

            // Check if a user exists
            $user = $this->userService->getById($userId);
            if (!$user) {
                return $this->responseNotFound('User Not Found');
            }

            // Revoke a group
            $this->userService->revokeGroup($userId, $groupId);
            return $this->responseSuccess();

        } catch (UserException $e) {

            // Bad Request
            return $this->responseBadRequest($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
