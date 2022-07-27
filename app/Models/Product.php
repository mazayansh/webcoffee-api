<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\{
    Roast,
    Type,
    ProductVariant,
    Media
};
use App\Helpers\QueryHelper;
use Illuminate\Support\Facades\DB;

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

    public function scopeJoinProductVariant($query)
    {
        return $query->leftJoin(
                        'product_variants', 
                        'products.id','=','product_variants.product_id')
                    ->select(
                        'products.id', 
                        'products.name', 
                        'products.slug',
                        'products.aftertaste', 
                        DB::raw('MIN(product_variants.price) AS price')
                    )
                    ->groupBy(
                        'products.id', 
                        'products.name', 
                        'products.slug', 
                        'products.aftertaste');
    }

    public function scopeWithFeaturedImage($query)
    {
        return $query->leftJoin(
                        'medias',
                        'products.id','=','medias.product_id')
                    ->where('medias.type', 'image')
                    ->where('medias.is_featured', 1)
                    ->addSelect('medias.path AS featured_image_url')
                    ->groupBy('featured_image_url');
    }

    /*
     * Format Query Params:
     * {sort order symbol: + asc, - desc}{attribute}
     * (,) delimiter for multiple sort
     * ex. +created_at,-name
     */
    public function scopeSortProduct($query, $sort_query_param)
    {
        return $query->when(
                        $sort_query_param, 
                        function($query, $sort_query_param) {
                            $sorts = explode(",", $sort_query_param);
                            array_walk(
                                $sorts, 
                                function($val, $key) use ($query) {
                                    $sort_order = $val[0] == '+' ? 'asc' : 'desc';
                                    $sort_attr = substr($val, 1);
                                    
                                    return $query->orderBy('products.'.$sort_attr, $sort_order);
                                }
                            );
                        }
                    );
    }

    public function scopeSearchProduct($query, $search_query_param)
    {
        return $query->when(
                    $search_query_param, 
                    function($query, $search_query_param) {
                        return $query->where('products.name','like',"%{$search_query_param}%");
                    }
                );
    }

    /*
     * Format Query Params:
     * attribute_value+attribute_value
     * (+) delimiter multiple filter
     * ex.  roast_dark+type_reserved+roast_medium
     */
    public function scopeFilterProduct($query, $filter_query_param)
    {
        return $query->when(
                    $filter_query_param, 
                    function($query, $filter_query_param) {
                        $filters = explode("+", $filter_query_param);
                        array_walk(
                            $filters, 
                            function($val, $key) use ($query) {
                                $filter_criteria_arr = explode("_", $val);
                                $filter_attribute = $filter_criteria_arr[0];
                                $filter_value = $filter_criteria_arr[1];

                                switch ($filter_attribute) {
                                    case 'roast':
                                        if (! QueryHelper::hasJoin($query->getQuery(), 'roasts')) {
                                            $query->join('roasts', 'products.roast_id', '=', 'roasts.id');
                                        }

                                        return $query->where('roasts.slug', $filter_value)->addSelect('roasts.slug as roast_slug')->groupBy('roast_slug');

                                        break;
                                    case 'type':
                                        if (! QueryHelper::hasJoin($query->getQuery(), 'types')) {
                                            $query->join('types', 'products.type_id', '=', 'types.id');
                                        }

                                        return $query->where('types.slug', $filter_value)->addSelect('types.slug as type_slug')->groupBy('type_slug');

                                        break;
                                }
                            }
                        );
                    }
                );
    }
}
