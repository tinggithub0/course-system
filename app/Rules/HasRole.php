<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class HasRole implements Rule
{
    private $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function passes($attribute, $value)
    {
        $user = User::find($value);

        return $user && $user->hasRole($this->role);
    }

    public function message()
    {
        return "The selected user is not a $this->role.";
    }
}