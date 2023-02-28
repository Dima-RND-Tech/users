<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Tests\TestCase;

class GetTest extends TestCase
{
    const ENDPOINT = '/api/users';

    /**
     * Response Structure
     *
     * @return void
     */
    public function testSuccessStructure(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('get', self::ENDPOINT.'/'.User::first()->id)
            ->assertOk()
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
