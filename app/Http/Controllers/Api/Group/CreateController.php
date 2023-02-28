<?php

namespace App\Http\Controllers\Api\Group;

use App\Exceptions\GroupException;
use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class CreateController extends AbstractController
{
    /**
     * @OA\Post(
     *      path="/groups",
     *      operationId="GroupsCreate",
     *      summary="Creates a new group",
     *      description="This API Endpoint creates a new group.",
     *      tags={"Groups"},
     *
     *     @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *                 type="object",
     *                    ref="#/components/schemas/Group"
     *                 )
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=201,
     *          description="Successfull Operation",
     *
     *          content={
     *
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *
     *                  @OA\Schema(
     *                      title="ResponseGroup",
     *                      type="object",
     *                      allOf={
     *                          @OA\Property(
     *                              ref="#/components/schemas/Group"
     *                          )
     *                      }
     *                  )
     *              )
     *          }
     *     ),
     *
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *     ),
     *
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
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
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_GROUPS_CREATE);

            // Check body
            $body = $request->post();
            if (empty($body['name'])) {
                return $this->responseBadRequest();
            }

            // Save a new group & respond
            return $this->responseCreated($this->groupService->create($body['name']));

        } catch (GroupException $e) {

            // Bad Request
            return $this->responseBadRequest($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
