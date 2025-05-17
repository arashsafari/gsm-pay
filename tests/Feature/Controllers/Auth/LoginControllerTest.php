<?php

namespace Tests\Feature\Controller\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushDB();
    }

    #[Test]
    public function shouldLoginSuccessfully(): void
    {
        $mobile = '09121112233';
        $password = '09121112233';
        User::factory()->create([
            'mobile' => $mobile,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson(route('auth.login', [
            'mobile' => $mobile,
            'password' => $password,
        ]));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'results' => [
                        'access_token',
                        'token_type',
                        'expires_in',
                    ],
                ],
                'server_time',
            ]);
    }

    #[Test]
    public function shouldThrowExceptionWhenPasswordWrong(): void
    {
        $mobile = '09121112233';
        $password = '09121112233';
        User::factory()->create([
            'mobile' => $mobile,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson(route('auth.login', [
            'mobile' => $mobile,
            'password' => '123465789',
        ]));

        $response->assertUnauthorized()
            ->assertJson([
                'data' => [
                    'results' => [],
                    'error_message' => 'mobile or password is wrong'
                ],
                'server_time' => Carbon::now()->toIso8601String()
            ]);
    }

    #[Test]
    public function shouldThrowExceptionWhenUserNotFound(): void
    {
        $mobile = '09121112233';
        $password = '09121112233';
        User::factory()->create([
            'mobile' => $mobile,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson(route('auth.login', [
            'mobile' => '09121112231',
            'password' => '09121112231',
        ]));

        $response->assertUnprocessable();
    }
}
