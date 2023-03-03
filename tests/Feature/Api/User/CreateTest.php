<?php

namespace Tests\Feature\Api\User;

use App\Models\Role;
use App\Models\User;
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

    /**
     * Bad Request (no data)
     *
     * @return void
     */
    public function testBadRequest(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('post', self::ENDPOINT)
            ->assertBadRequest()
        ;
    }

    /**
     * Bad Request (user exists)
     *
     * @return void
     */
    public function testAlreadyExists(): void
    {
        $user = User::first();

        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('post', self::ENDPOINT, [
                'name' => $user->name,
                'roleId' => $user->role_id
            ])
            ->assertBadRequest()
        ;
    }
}
