<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'description', 'image', 'active', 'order'])]
class Fair extends Model
{
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(FairImage::class)->orderBy('order')->orderBy('id');
    }
}
