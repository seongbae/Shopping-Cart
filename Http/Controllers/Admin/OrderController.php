<?php

namespace App\Modules\Cart\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\Cart\DataTables\OrdersDataTable;
use App\Modules\Cart\Models\Order;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use App\Modules\Cart\Services\CartService;

class OrderController extends \App\Http\Controllers\Controller
{
    use UploadTrait;

    protected $cartService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        $this->middleware('auth');
        
        $this->cartService = $cartService;
    }   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $datatable)
    {
        return $datatable->render('cart::admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('cart::admin.orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        
    }

    public function updateShipping(Request $request, $id)
    {
        $this->cartService->updateShipping($id, $request->get('carrier'), $request->get('code'), $request->get('label_created') == 1, $request->get('shipped') == 1, $request->get('notify') == 1);

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
        
    }

}
