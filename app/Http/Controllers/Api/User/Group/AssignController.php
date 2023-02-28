<?php

namespace App\Http\Controllers\Api\User\Group;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class AssignController extends AbstractController
{
    /**
     * @OA\Put(
     *      path="/users/{userId}/groups/{groupId}/assign",
     *      operationId="UsersGroupsAssign",
     *      summary="Assigns a user to a group",
     *      description="This API Endpoint assigns users to groups.",
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
     *          description="Successfull Operation",
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
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_GROUPS_CREATE);

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

            // Assign a group
            $this->userService->assignGroup($userId, $groupId);
            return $this->responseSuccess();

        } catch (UserException $e) {

            // Forbidden
            return $this->responseForbidden($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
