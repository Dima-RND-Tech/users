<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class GetController extends AbstractController
{
    /**
     * @OA\Get(
     *      path="/users/{userId}",
     *      operationId="UsersGet",
     *      summary="Gets a user by ID",
     *      description="This API Endpoint get a user by ID.",
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
     *     @OA\Response(
     *          response=200,
     *          description="Successfull Operation",
     *
     *          content={
     *
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *
     *                  @OA\Schema(
     *                      type="object",
     *                      ref="#/components/schemas/User"
     *                  )
     *              )
     *          }
     *     ),
     *
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *     ),
     *
     *     @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *     ),
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
    public function index(Request $request, string $userId)
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_GET);

            // Check params
            $userId = intval($userId);
            if (empty($userId)) {
                return $this->responseBadRequest();
            }

            // Getting a user by ID
            $user = $this->userService->getById($userId);

            // Checking result
            if (empty($user)) {
                return $this->responseNotFound();
            }

            // Successful result
            return $this->responseSuccess($user);

        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
