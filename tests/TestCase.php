<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createUserWithTokenRequest($userRole = User::ROLE_STUDENT, $userId = null, $user = null)
    {
        $user = $user ?? ($userId 
                            ? User::find($userId)
                            : User::factory()->create([
                                'role' => $userRole
                            ]));
        $token = $user->createToken('test-token')->plainTextToken;

        return $this->actingAs($user, 'api')
            ->withHeaders(['Authorization' => 'Bearer ' . $token]);
    }
}
