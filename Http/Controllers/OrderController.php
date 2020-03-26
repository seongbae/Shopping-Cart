<?php

namespace App\Modules\Cart\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Modules\Cart\Services\CartService;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;

class OrderController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartService $cs)
    {
        $token = $request->get('payment_id');
        $total = $request->get('total');
        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $street = $request->get('street');
        $street2 = $request->get('street2');
        $city = $request->get('city');
        $state = $request->get('state');
        $zip = $request->get('zip');
        $ccName = $request->get('card_name');
        $subtotal = $request->get('subtotal');
        $tax = $request->get('tax');
        $shipping = $request->get('shipping');
        $total = $request->get('total');
        $donation = $request->get('donation');
        $notes = 'Donation amount: '. $donation;
        $ccName = $request->get('card_name');
        $ccLast4 = $request->get('cardnumber');
        //$orderItems = array('1'=>$request->get('quantity'));

        $intent = null;
        $order = null;

        $products = $request->get('product');
        $price = $request->get('price');
        $quantity = $request->get('quantity');
        $cartItems = collect();

        for($i=0;$i<count($products);$i++)
        {
            $orderItems[] = array('product_id'=>$products[$i],'price'=>$price[$i], 'quantity'=>$quantity[$i]);
        }

        $orderNum = Helper::random_integer(6);

        $order = $cs->createOrder($token, $firstName, $lastName, $email, $phone, $street, $street2, $city, $state, $zip, $ccName, $ccLast4, $subtotal, $tax, $shipping, $total, Auth::id(), $orderItems, $donation, $notes);

        // try {
        //     Stripe::setApiKey(option('stripe_private_key'));

        //     if (isset($token)) {
        //         $orderNum = Helper::random_integer(6);

        //         $intent = \Stripe\PaymentIntent::create([
        //             'payment_method' => $token,
        //             'amount' => $total*100,
        //             'currency' => 'usd',
        //             //'confirmation_method' => 'manual',
        //             'confirm' => true,
        //             'description' => 'Order:'. $orderNum,
        //             'metadata' => [
        //                 'order_id' => $orderNum,
        //                 'donation_amount' => $donation
        //               ],
        //         ]);

        //         $status = 'paid';
        //         $ccLast4 = '1234';
        
        //         // $intent = \Stripe\PaymentIntent::retrieve(
        //         //     $token
        //         // );

        //         // $intent->confirm();


        //         $order = $cs->createOrder($firstName, $lastName, $email, $street, $street2, $city, $state, $zip, $ccName, $ccLast4, $subtotal, $tax, $shipping, $total, Auth::id(), $status, $notes, $orderNum, $orderItems);

        //         Log::info('stripe success');
        //     }
        //     //$this->generateResponse($intent);
        // } catch (\Stripe\Exception\ApiErrorException $e) {
        //     # Display error on client
        //     Log::info(json_encode([
        //       'error' => $e->getMessage()
        //     ]));
        // }   

        if ($order)
        {
            Session::forget('cart');
            flash()->success('Thank you for the purchase. An e-mail was sent to '.$order->email.'. You will be notified when the order is shipped.');
        }
        else
        {
            flash()->error('Please try again later.');
            return redirect()->back();
        }

        return redirect()->route('cart.thankyou');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    public function showThankyou()
    {
        return view('cart::checkout.thankyou');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
