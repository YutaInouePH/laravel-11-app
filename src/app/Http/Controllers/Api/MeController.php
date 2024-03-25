<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    /**
     * Display authenticated user resource.
     */
    public function index(): UserResource
    {
        $me = auth()->user();

        return new UserResource($me);
    }
}
