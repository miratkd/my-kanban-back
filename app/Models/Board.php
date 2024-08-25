<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Board extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function haveAccess($id) {
        if ($this->user_id == $id) return true;
        return false;
    }
}
