<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\GroupServiceInterface;
use App\Interfaces\RoleServiceInterface;
use App\Interfaces\UserServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * @OA\Info(
 *      title="User Management System API",
 *      description="API Endpoints for getting and changing users, groups & roles",
 *      version=L5_SWAGGER_API_VERSION
 * ),
 *
 * @OA\Server(
 *      description="Local",
 *      url=L5_SWAGGER_CONST_HOST_LOCAL
 * ),
 *
 * @OA\OpenApi(
 *      security={{"token": {}}}
 * ),
 *
 * @OA\Components(
 *
 *      @OA\SecurityScheme(
 *          securityScheme="token",
 *          type="apiKey",
 *          in="header",
 *          name="x-api-key"
 *      )
 * )
 */
abstract class AbstractController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        protected readonly UserServiceInterface  $userService,
        protected readonly RoleServiceInterface  $roleService,
        protected readonly GroupServiceInterface $groupService,
    ) {}

    protected function checkPermission(Request $request, string $operation): void
    {
        if (!$this->roleService->isOperationPermitted($request->apiUser?->roleId, $operation)) {
            response('Method Not Allowed', SymfonyResponse::HTTP_METHOD_NOT_ALLOWED)->send();
            exit;
        }
    }

    protected function responseSuccess(mixed $content = null)
    {
        if (!empty($content)) {
            return response()->json($content)->setStatusCode(SymfonyResponse::HTTP_OK);
        } else {
            return response(null,SymfonyResponse::HTTP_NO_CONTENT);
        }
    }

    protected function responseCreated(mixed $content)
    {
        return response()->json($content)->setStatusCode(SymfonyResponse::HTTP_CREATED);
    }

    protected function responseBadRequest(string $message = 'Bad Request')
    {
        return response($message, SymfonyResponse::HTTP_BAD_REQUEST);
    }

    protected function responseNotFound(string $message = 'Resource Not Found')
    {
        return response($message, SymfonyResponse::HTTP_NOT_FOUND);
    }

    protected function responseForbidden(string $message = 'Forbidden')
    {
        return response($message, SymfonyResponse::HTTP_FORBIDDEN);
    }

    protected function responseInternalError(string $message = 'Internal Server Error')
    {
        return response($message, SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
