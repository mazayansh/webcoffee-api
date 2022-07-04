<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Roast;
use App\Models\Type;
use App\Models\ProductVariant;
use App\Models\Media;

class Product extends Model
{
    use HasFactory;

    public function roast(): BelongsTo
    {
        return $this->belongsTo(Roast::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
