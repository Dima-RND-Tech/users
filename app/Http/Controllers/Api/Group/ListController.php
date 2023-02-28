<?php

namespace App\Http\Controllers\Api\Group;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Http\Resources\GroupResource;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class ListController extends AbstractController
{
    /**
     * @OA\Get(
     *      path="/groups",
     *      operationId="GroupsList",
     *      summary="Gets list of all user groups",
     *      description="This API Endpoint returns lists of all user groups.",
     *      tags={"Groups"},
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
    public function index(Request $request): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_GROUPS_LIST);

            // Getting groups from storage
            $groups = $this->groupService->getList();

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
