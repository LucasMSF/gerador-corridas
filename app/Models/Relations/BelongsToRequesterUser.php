<?php

namespace App\Models\Relations;

use App\Models\User;

trait BelongsToRequesterUser 
{
    public function requesterUser(): User
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }
}