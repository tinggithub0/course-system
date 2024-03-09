<?php

namespace Tests;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    }

    protected function createUserWithTokenRequest($userRole = '', $userId = null, $user = null)
    {
        $userRole ??= UserRole::STUDENT->value;
        $user = $user ?? ($userId 
                            ? User::find($userId)
                            : User::factory()->create()->assignRole($userRole));
        $token = $user->createToken('test-token')->plainTextToken;

        return $this->actingAs($user, 'api')
            ->withHeaders(['Authorization' => 'Bearer ' . $token]);
    }
}
