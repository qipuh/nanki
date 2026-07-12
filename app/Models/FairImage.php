<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['fair_id', 'image', 'order'])]
class FairImage extends Model
{
    public function fair(): BelongsTo
    {
        return $this->belongsTo(Fair::class);
    }
}
