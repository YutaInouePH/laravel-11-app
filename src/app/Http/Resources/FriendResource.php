<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Overtrue\LaravelFollow\Followable;

/**
 * @mixin Followable
 * @property string $accepted_at
 */
class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = $this->accepted_at === null ? 'pending' : 'accepted';

        return [
            'id' => $this->followable->id,
            'name' => $this->followable->name,
            'email' => $this->followable->email,
            'status' => $status,
        ];
    }
}
