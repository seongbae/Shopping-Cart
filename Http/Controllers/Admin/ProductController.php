<?php

namespace App\Modules\Cart\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UploadTrait;
use App\Modules\Cart\DataTables\ProductsDataTable;
use App\Modules\Cart\Services\CartService;
use App\Modules\Cart\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends \App\Http\Controllers\Controller
{
    use UploadTrait;

    protected $productService;

    public function __construct(CartService $productService)
    {
        $this->middleware('auth');
        
        $this->productService = $productService;
    }   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $datatable)
    {
        Log::info('Loading products...');
        return $datatable->render('cart::admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cart::admin.products.create')
                ->with('product', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');
        $img = $request->file('photo_url');
        
        $product = $this->productService->createProduct($name, $price, $description, $img);

        if ($product)
            flash()->success('Product saved');
        else
            flash()->error('Product could not be saved');

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.orders.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('cart::admin.products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $price = $request->get('price');
        $img = $request->file('photo_url');
        
        $product = $this->productService->updateProduct($product, $name, $price, $description, $img);

        if ($product)
            flash()->success('Product updated');
        else
            flash()->error('Product could not be updated');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.products.index');
    }

    public function showRegistrations(RegistrationsDataTable $datatable)
    {
        return $datatable->render('admin.events.registrations');
    }
}
