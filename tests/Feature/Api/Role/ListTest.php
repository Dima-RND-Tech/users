<?php

namespace Tests\Feature\Api\Role;

use App\Models\Role;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;

class ListTest extends TestCase
{
    const ENDPOINT = '/api/roles';

    /**
     * Response Code
     *
     * @return void
     */
    public function testUnauthorized(): void
    {
        $this->get(self::ENDPOINT)
            ->assertStatus(SymfonyResponse::HTTP_UNAUTHORIZED)
            ;
    }

    /**
     * Response Header
     *
     * @return void
     */
    public function testSuccessHeader(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->get(self::ENDPOINT)
            ->assertOk()
            ->assertHeader('Content-Type', 'application/json');
    }

    /**
     * Response Structure
     *
     * @return void
     */
    public function testSuccessStructure(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('get', self::ENDPOINT)
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            )
            ->assertHeader('Content-Type', 'application/json');
    }

    /**
     * Response Data Count
     *
     * @return void
     */
    public function testSuccessDataCount(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('get', self::ENDPOINT)
            ->assertOk()
            ->assertJsonCount(Role::all()?->count())
            ->assertHeader('Content-Type', 'application/json');
    }
}
