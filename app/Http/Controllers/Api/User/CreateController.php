<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class CreateController extends AbstractController
{
    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="UsersCreate",
     *      summary="Creates a new user",
     *      description="This API Endpoint creates a new user.",
     *      tags={"Users"},
     *
     *     @OA\RequestBody(
     *          required=true,
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *                 type="object",
     *                    ref="#/components/schemas/User"
     *                 )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Successfull Operation",
     *
     *          content={
     *
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *
     *                  @OA\Schema(
     *                      title="ResponseUser",
     *                      type="object",
     *                      allOf={
     *                          @OA\Property(
     *                              ref="#/components/schemas/User"
     *                          )
     *                      }
     *                  )
     *              )
     *          }
     *      ),
     *
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      ),
     *
     *      @OA\Response(
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
            $this->checkPermission($request, RoleServiceInterface::PERMISSION_USERS_CREATE);

            // Check body params
            $body = $request->post();
            if (empty($body['name'])) {
                return $this->responseBadRequest('Invalid Name');
            }

            if (empty($body['roleId'])) {
                return $this->responseBadRequest('Invalid Role ID');
            }

            // Save a new user & return result
            return $this->responseCreated($this->userService->create($body['name'], $body['roleId']));

        } catch (UserException $e) {

            // Bad Request
            return $this->responseBadRequest($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
