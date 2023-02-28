<?php

namespace App\Http\Resources;

/**
 * @OA\Schema(
 *      schema="Role",
 *      type="object",
 *      description="Role Resource"
 * )
 */
class RoleResource
{
    public function __construct(
        /**
         * @OA\Property(
         *      property="id",
         *      type="integer",
         *      description="Role ID",
         *      example=0
         * )
         * @var integer $id
         */
        public int $id,

        /** @OA\Property(
         *      property="name",
         *      type="string",
         *      description="Role name",
         *      example="Administator",
         *      maxLength=32
         * )
         * @var string $name
         */
        public string $name
    ) {}
}
