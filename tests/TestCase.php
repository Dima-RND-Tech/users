<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Prepare the test
    public function setUp(): void
    {
        parent::setUp();

        $this->prepareForTests();
    }

    // Migrate the database
    private function prepareForTests()
    {
        Artisan::call('migrate --seed');
    }

}
