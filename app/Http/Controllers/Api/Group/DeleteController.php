<?php

namespace App\Http\Controllers\Api\Group;

use App\Exceptions\GroupException;
use App\Exceptions\StorageException;
use App\Http\Controllers\Api\AbstractController;
use App\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class DeleteController extends AbstractController
{
    /**
     * @OA\Delete(
     *      path="/groups/{groupId}",
     *      operationId="GroupsDelete",
     *      summary="Deletes a group",
     *      description="This API Endpoint deletes a group.",
     *      tags={"Groups"},
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
     *          description="Deleted"
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
     *          response=403,
     *          description="Forbidden"
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
    public function index(Request $request, string $groupId): object
    {
        try {
            // Check operation allowance
            $this->checkPermission($request,RoleServiceInterface::PERMISSION_GROUPS_DELETE);

            // Check parameter
            $groupId = intval($groupId);
            if (empty($groupId)) {
                return $this->responseBadRequest();
            }

            // Check if a group exists
            $group = $this->groupService->getById($groupId);
            if (!$group) {
                return $this->responseNotFound();
            }

            // Delete a group
            if ($this->groupService->delete($groupId)) {
                return $this->responseSuccess();
            } else {
                // If nothing deleted
                return $this->responseNotFound();
            }

        } catch (GroupException $e) {
            // Forbidden if cannot delete
            return $this->responseForbidden($e->getMessage());
        } catch (StorageException $e) {

            // Internal Error
            return $this->responseInternalError($e->getMessage());
        }
    }
}
