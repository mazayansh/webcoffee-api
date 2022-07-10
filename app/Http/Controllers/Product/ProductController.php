<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
                        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                        ->select(
                            'products.id', 
                            'products.name', 
                            'products.aftertaste', 
                            DB::raw('MIN(product_variants.price) AS price')
                        )
                        ->groupBy('products.id', 'products.name', 'products.aftertaste')
                        ->when(
                            $sort_query_param = $request->query('sort'), 
                            function($query, $sort_query_param) {
                                $sorts = explode(",", $sort_query_param);
                                array_walk(
                                    $sorts, 
                                    function($val, $key) use ($query) {
                                        $sort_order = $val[0] == '+' ? 'asc' : 'desc';
                                        $sort_attr = substr($val, 1);
                                        
                                        return $query->orderBy($sort_attr, $sort_order);
                                    }
                                );
                            }
                        )
                        ->when(
                            $search_query_param = $request->query('name'), 
                            function($query, $search_query_param) {
                                return $query->where('products.name','like',"%{$search_query_param}%");
                            }
                        )
                        ->when(
                            $filter_query_param = $request->query('filter'), 
                            function($query, $filter_query_param) {
                                // filter_query_param -> roast_dark+type_reserved+roast_medium
                                $filters = explode("+", $filter_query_param);
                                // filters -> 0:roast_dark, 1:type_reserved, 2:roast_medium
                                array_walk(
                                    $filters, 
                                    function($val, $key) use ($query) {
                                        $filter_criteria_arr = explode("_", $val);
                                        $filter_attribute = $filter_criteria_arr[0];
                                        $filter_value = $filter_criteria_arr[1];

                                        switch ($filter_attribute) {
                                            case 'roast':
                                                if (!$this->hasJoin($query->getQuery(), 'roasts')) {
                                                    $query->join('roasts', 'products.roast_id', '=', 'roasts.id');
                                                }
                                                return $query->where('roasts.name', $filter_value);
                                                break;
                                            case 'type':
                                                if (!$this->hasJoin($query->getQuery(), 'types')) {
                                                    $query->join('types', 'products.type_id', '=', 'types.id');
                                                }
                                                return $query->where('types.name', $filter_value);
                                                break;
                                        }
                                    }
                                );
                            }
                        )
                        ->get();

        return new ProductCollection($products);
    }

    function hasJoin(Builder $builder, $table)
    {
        foreach ($builder->joins as $joinClause) {
            if ($joinClause->table == $table) {
                return true;
            }
        }

        return false;
    }
}
