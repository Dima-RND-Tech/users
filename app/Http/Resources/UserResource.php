<?php

namespace App\Http\Resources;

/**
 * @OA\Schema(
 *      schema="User",
 *      type="object",
 *      description="User Resource"
 * )
 */
class UserResource
{
    public function __construct(
        /**
         * @OA\Property(
         *      property="id",
         *      type="integer",
         *      description="User ID",
         *      example=0
         * )
         * @var integer $id
         */
        public int $id,

        /**
         * @OA\Property(
         *      property="roleId",
         *      type="integer",
         *      description="Role ID",
         *      example=0
         * )
         * @var integer $roleId
         */
        public int $roleId,

        /** @OA\Property(
         *      property="name",
         *      type="string",
         *      description="User name",
         *      example="John",
         *      maxLength=64
         * )
         * @var string $name
         */
        public string $name
    ) {}
}
