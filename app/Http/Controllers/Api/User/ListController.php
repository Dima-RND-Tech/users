<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class ListController extends AbstractController
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="UsersList",
     *      summary="Gets list of all users",
     *      description="This API Endpoint returns lists of all existing users.",
     *      tags={"Users"},
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successfull Operation",
     *
     *          content={
     *
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *
     *                  @OA\Schema(
     *                      type="array",
     *
     *                      @OA\Items(
     *                          ref="#/components/schemas/User"
     *                      )
     *                  )
     *              )
     *          }
     *      ),
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
     *     ),
     *
     *     @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *     )
     * )
     */
    public function index(Request $request): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_LIST);

            // Getting users from storage
            $users = $this->userService->getList();

            // Checking results
            if (empty($users)) {
                return $this->responseNotFound();
            }

            // Successful result
            return $this->responseSuccess($users);

        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
