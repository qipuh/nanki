<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['image', 'alt', 'caption', 'active', 'order'])]
class GalleryImage extends Model
{
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
