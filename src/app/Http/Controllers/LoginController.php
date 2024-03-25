<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request): Response
    {
        $request->authenticate();
        $request->session()->regenerate();

        return response()->noContent();
    }
}
