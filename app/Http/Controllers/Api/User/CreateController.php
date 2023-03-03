<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\StorageException;
use App\Exceptions\UserException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

            // Validate request
            $validator = Validator::make($request->post(), [
                'name' => 'required|unique:groups|max:64',
                'roleId'=> 'required|exists:roles,id|integer'
            ]);

            if ($validator->fails()) {
                return $this->responseBadRequest($validator->messages()->toArray());
            }

            // Save a new user & return result
            return $this->responseCreated($this->userService->create($request->post('name'), intval($request->post('roleId'))));

        } catch (UserException $e) {

            // Bad Request
            return $this->responseBadRequest($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
