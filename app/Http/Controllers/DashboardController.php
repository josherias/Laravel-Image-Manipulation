<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'tokens' => $user->tokens
        ]);
    }

    public function showTokenForm ()
    {
        return view('token-create');
    }

    public function createToken(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $tokenName = $request->post('name');

        $user = $request->user();
        $token = $user->createToken($tokenName);

        return view('token-show', [
            'tokenName' => $tokenName,
            'token' => $token->plainTextToken
        ]);
    }

    public function deleteToken(PersonalAccessToken $token)
    {
        $token->delete();

        return redirect('dashboard');

    }
}
