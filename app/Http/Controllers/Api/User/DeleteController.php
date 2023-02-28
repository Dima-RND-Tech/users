<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class DeleteController extends AbstractController
{
    /**
     * @OA\Delete(
     *      path="/users/{userId}",
     *      operationId="UsersDelete",
     *      summary="Deletes a user",
     *      description="This API Endpoint deletes a user.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successfull Operation"
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *
     *     @OA\Response(
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
    public function index(Request $request, string $userId): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_DELETE);

            // Check parameter
            $userId = intval($userId);
            if (empty($userId)) {
                return $this->responseBadRequest();
            }

            // Check if a user exists
            $user = $this->userService->getById($userId);
            if (!$user) {
                return $this->responseNotFound();
            }

            // Self-deleting preventing
            if ($user->id == $request->apiUser->id) {
                return $this->responseForbidden('Self-Destruction Prevented');
            }

            // Delete a user
            $this->userService->delete($userId);
            return $this->responseSuccess();

        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
