<?php

namespace App\Http\Controllers\Api\Role;

use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class ListController extends AbstractController
{
    /**
     * @OA\Get(
     *      path="/roles",
     *      operationId="RolesList",
     *      summary="Gets list of all user roles",
     *      description="This API Endpoint returns lists of all user roles.",
     *      tags={"Roles"},
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
     *                          ref="#/components/schemas/Role"
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
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_ROLES_LIST);

            // Getting roles from storage
            $roles = $this->roleService->getList();

            // Checking results
            if (empty($roles)) {
                return $this->responseNotFound();
            }

            // Successful result
            return $this->responseSuccess($roles);

        } catch (StorageException $e) {
            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
