<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use lluminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
