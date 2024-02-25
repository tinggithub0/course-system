<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Token\StoreRequest;

class TokenController extends Controller
{
    public function store(StoreRequest $request)
    {
        $token = User::find($request->validated('user_id'))
            ->createToken($request->validated('token_name'));

        return response()->json(['token' => $token->plainTextToken], 201);
    }
}
