<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $request = request();
        $this->validate($request, ['type' => 'required']);

        $type = $request->type;
        $per_page = $request->per_page ?? 10;

        $products = DB::table('products')
            ->where('products.type' ,$type)
            ->join('product_categories', function($join) {
                $join->on('product_categories.id','=','products.product_category_id');
            })
            ->select(
                'products.*',
                'product_categories.title as category_title'
            );

        $paginated = $products->paginate($per_page);

        return response()->json($paginated);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'name' => 'required',
        ]);

        $name = $request->name;
        $type = $request->type;
        $category = $request->category;
        $price = (float)$request->price;
        $id = $request->id;

        $product_category = ProductCategory::firstOrCreate([
            'tag' => $category,
        ],[
            'title' => $category,
            'description' => ''
        ]);

        $action = 'guardado';
        if (isset($id)) {
            $action = 'actualizado';
            $product = Product::where('id', $id)->first();
            $product->name = $name;
            $product->type = $type;
            $product->price = $price;
            $product->product_category_id = $product_category->id;
            $product->save();
        } else {
            $product = Product::create([
                'name' => $name,
                'type' => $type,
                'product_category_id' => $product_category->id
            ]);
        }


        return response()->json([
            'error' => false,
            'msg' => ($type === 'service' ? 'Servicio ' : 'Producto ' ) . "{$action} exitosamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forSelect(Request $request)
    {
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $product->value = $product->id;
            $product->label = $product->name;
        }

        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $product_type = $product->type;
        $product->delete();

         return response()->json([
            'error' => false,
            'msg' => ($product_type === 'service' ? 'Servicio ' : 'Producto ' ) . 'eliminado exitosamente'
        ]);
    }
}
