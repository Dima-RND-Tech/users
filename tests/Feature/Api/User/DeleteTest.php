<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    const ENDPOINT = '/api/users';

    /**
     * Successful Deletion
     *
     * @return void
     */
    public function testSuccessDeletion(): void
    {
        $adminUser = User::whereApiKey(env('API_KEY_DEFAULT'))->first();
        $user = User::where('id', '!=', $adminUser->id)->first();

        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('delete', self::ENDPOINT.'/'.$user->id)
            ->assertNoContent()
            ;
    }

    /**
     * Self-Destruction Prevention
     *
     * @return void
     */
    public function testSelfDestructionPrevention(): void
    {
        $user = User::whereApiKey(env('API_KEY_DEFAULT'))->first();

        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('delete', self::ENDPOINT.'/'.$user->id)
            ->assertForbidden()
            ;
    }

    /**
     * Bad Request (without ID)
     *
     * @return void
     */
    public function testBadRequest(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('delete', self::ENDPOINT.'/0')
            ->assertBadRequest()
            ;
    }

    /**
     * User Not Found
     *
     * @return void
     */
    public function testNotFound(): void
    {
        $this->withHeaders(['x-api-key' => env('API_KEY_DEFAULT')])
            ->json('delete', self::ENDPOINT.'/-1')
            ->assertNotFound()
            ;
    }
}
