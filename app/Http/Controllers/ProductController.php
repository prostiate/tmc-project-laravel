<?php

namespace App\Http\Controllers;

use App\Helpers\SpecialFilter;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        $query->join('categories', 'products.categories_id', '=', 'categories.id');
        if (str_contains($request->getRequestUri(), '/api/search') && str_contains($request->getRequestUri(), '?')) {
            $arr = [];
            $url = urldecode($request->getRequestUri());
            $queryString = explode('?', $url);
            $queryString = explode('&', $queryString[1]);
            foreach ($queryString as $item) {
                $q = explode('=', $item);
                if (isset($arr[$q[0]])) {
                    array_push($arr[$q[0]], $q[1]);
                } else {
                    $arr[$q[0]] = [$q[1]];
                }
            }
            $lookfor = ['sku', 'name', 'price', 'stock', 'category.id', 'category.name'];
            foreach ($lookfor as $value) {
                $iterator = new SpecialFilter($arr, $value);
                $result = iterator_to_array($iterator);
                if ($result) {
                    if (in_array($value, ['price', 'stock'])) {
                        ksort($result);
                        $filter = [$result[$value . '.start'][0], $result[$value . '.end'][0]];
                        $query->where(fn ($q) => $q->where($value, '>=', $filter[0])->where($value, '<=', $filter[1]));
                    } else if (in_array($value, ['category.id'])) {
                        $query->whereIn('categories_id', array_values($result)[0]);
                    } else if (in_array($value, ['category.name'])) {
                        $query = $query->whereIn('categories.name', array_values($result)[0]);
                    } else {
                        $query = $query->whereIn('products.' . $value, array_values($result)[0]);
                    }
                }
            }
        }
        $query = $query->paginate(5);
        return response()->json(new ProductCollection($query));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['categories_id'] = $validated['categoryId'];
            unset($validated['categoryId']);
            $data = Product::create($validated);
            DB::commit();
            return response()->json(['data' => new ProductResource($data)], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['erors' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
