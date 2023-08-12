<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_authenticate_a_user_with_valid_credentials()
    {
        // create a user
        User::factory()->create([
            'username' => 'imsat',
            'password' => bcrypt('password'),
        ]);

        // create an instance of the AuthService
        $authService = new AuthService();

        // attempt to authenticate the user
        $result = $authService->authenticate('imsat', 'password');

        //assert that the authentication was successful
        $this->assertTrue($result);
    }


    /** @test */
    public function it_cannot_authenticate_a_user_with_invalid_credentials()
    {
        // create a user
        User::factory()->create([
            'username' => 'imsat',
            'password' => bcrypt('password'),
        ]);

        // create an instance of the AuthService
        $authService = new AuthService();

        // attempt to authenticate the user with wrong password
        $result = $authService->authenticate('imsat', 'wrongpassword');

        // Assert that the authentication was not successful
        $this->assertFalse($result);
    }

}
