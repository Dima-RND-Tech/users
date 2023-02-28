<?php

namespace App\Http\Controllers\Api\User\Group;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class ListController extends AbstractController
{
    /**
     * @OA\Get(
     *      path="/users/{userId}/groups",
     *      operationId="UsersGroupsGet",
     *      summary="Get groups of a user",
     *      description="This API Endpoint get groups of a user.",
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
     *                          ref="#/components/schemas/Group"
     *                      )
     *                  )
     *              )
     *          }
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
    public function index(Request $request, string $userId): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_GROUPS_LIST);

            // Check params
            $userId = intval($userId);
            if (empty($userId)) {
                return $this->responseBadRequest();
            }

            // Getting groups by user ID from storage
            $groups = $this->groupService->getListByUserId($userId);

            // Checking results
            if (empty($groups)) {
                return $this->responseNotFound();
            }

            // Successful result
            return $this->responseSuccess($groups);

        } catch (StorageException $e) {
            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
