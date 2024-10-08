<?php

namespace App\Models\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToRequesterUser 
{
    public function requesterUser(): BelongsTo|User
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }
}