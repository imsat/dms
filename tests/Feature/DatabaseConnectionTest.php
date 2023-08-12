<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_connect_to_database()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception) {
            $this->fail('Failed to connect the database. Check your database configuration.');
        }

        // the connection was successful.
        $this->assertTrue(true);
    }
}
