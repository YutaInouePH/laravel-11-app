<?php

namespace App;

enum FriendStatus: int
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case BLOCKED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::BLOCKED => 'Blocked',
        };
    }

}
