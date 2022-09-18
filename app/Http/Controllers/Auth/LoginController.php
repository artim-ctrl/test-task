<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'password' => 'Incorrect email or password',
                ],
            ]);
        }

        $data = Auth::user()->toArray();
        $data['token'] = Auth::user()->createToken('MyApp')->plainTextToken;

        return response()->json([
            'data' => $data,
        ]);
    }
}
