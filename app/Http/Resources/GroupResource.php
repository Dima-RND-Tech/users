<?php

namespace App\Http\Resources;

/**
 * @OA\Schema(
 *      schema="Group",
 *      type="object",
 *      description="Group Resource"
 * )
 */
class GroupResource
{
    public function __construct(
        /**
         * @OA\Property(
         *      property="id",
         *      type="integer",
         *      description="Group ID",
         *      example=0
         * )
         * @var integer $id
         */
        public int $id,

        /** @OA\Property(
         *      property="name",
         *      type="string",
         *      description="Group name",
         *      example="Developers",
         *      maxLength=64
         * )
         * @var string $name
         */
        public string $name) {}
}
