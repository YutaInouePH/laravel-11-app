<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $user1 = $users->first();
        $user2 = $users->get(2);
        $user3 = $users->get(3);

        // User 1 sends friend request to user 2, and accepts
        $user1->follow($user2);
        $user2->follow($user1);
        $user1->acceptFollowRequestFrom($user2);
        $user2->acceptFollowRequestFrom($user1);

        // User 1 sends friend request to user 3,and user 3 is still waiting.
        $user1->follow($user3);

        // User 2 sends friend request to user 3, and user 3 accepts
        $user2->follow($user3);
        $user3->follow($user2);
        $user2->acceptFollowRequestFrom($user3);
        $user3->acceptFollowRequestFrom($user2);
    }
}
