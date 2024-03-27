<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register\StoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function store(StoreRequest $request): UserResource|JsonResponse
    {
        $user = null;
        DB::beginTransaction();
        try {
            $user = User::create($request->data());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(__CLASS__.'@'.__METHOD__, [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to register user.',
            ], 500);
        }

        return new UserResource($user);
    }
}
