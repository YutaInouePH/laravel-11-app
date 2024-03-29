<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Models\User;
use Illuminate\Http\Request;
use Overtrue\LaravelFollow\Followable;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        $me = auth()->user();

        //　Use the Followable model instead of the User model to query.
        $friends = Followable::query()
            ->with('followable')
            ->where('user_id', $me->id)
            ->where('followable_type', User::class)
            ->paginate();

        return FriendResource::collection($friends);
    }
}
