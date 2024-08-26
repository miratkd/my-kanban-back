<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    public function owner(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    public function haveAccess($id) {
        if ($this->user_id == $id) return true;
        return false;
    }

    public function initStatuses() {
        $genericStatus = new Status();
        $genericStatus->title = 'Aguardando';
        $genericStatus->color = 'yellow';
        $genericStatus->position = 0;
        $genericStatus->board_id = $this->id;
        $genericStatus->save();
        $genericStatus = new Status();
        $genericStatus->title = 'Em andamento';
        $genericStatus->color = 'blue';
        $genericStatus->position = 1;
        $genericStatus->board_id = $this->id;
        $genericStatus->save();
        $genericStatus = new Status();
        $genericStatus->title = 'Finalizado';
        $genericStatus->color = 'green';
        $genericStatus->position = 2;
        $genericStatus->board_id = $this->id;
        $genericStatus->save();
    }
}
