<?php

namespace Tests\Feature\Api\User;

use App\Models\Role;
use Tests\TestCase;

class CreateTest extends TestCase
{
    const ENDPOINT = '/api/users';

    /**
     * Response Structure
     *
     * @return void
     */
    public function testSuccessCreation(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('post', self::ENDPOINT,[
                'roleId' => Role::first()->id,
                'name' => 'John-'.time()
            ])
            ->assertCreated()
            ->assertJsonStructure(
                [
                    'id',
                    'roleId',
                    'name'
                ]
            )
            ->assertHeader('Content-Type', 'application/json');
    }
}
