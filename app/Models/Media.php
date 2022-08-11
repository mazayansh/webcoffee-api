<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use lluminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Product;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => config('app.url').'/storage'.$value,
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
