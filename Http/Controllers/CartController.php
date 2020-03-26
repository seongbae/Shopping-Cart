<?php

namespace App\Modules\Cart\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Cart\Services\CartService;
use \Stripe\Stripe;
use Illuminate\Support\Facades\Log;
use App\Modules\Cart\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Modules\Cart\Models\CartItem;

class CartController extends \App\Http\Controllers\Controller
{
    public function showCheckout()
    {
        $total = 0;
    	$subtotal = 0;
    	$donation = 5;
        $shipping = option('shipping_amount', 0);
        
        //$cart = json_decode(json_encode(Session::get('cart', array())), true);

        $cart = Session::get('cart', array());
        
        $cartItems = collect();

        Log::info('cart:' . json_encode($cart));

        foreach ($cart as $item) { // This will search in the 2 jsons
             foreach($item as $key => $value) {
                $item = Product::find($key);
                $cartItem = new CartItem();
                $cartItem->item = $item;
                $cartItem->quantity = $value;
                $cartItem->subtotal = $item->price * $value;
                $cartItems->push($cartItem);
                $total = $total + $cartItem->subtotal;
            }
        }

        $tax = 0 ; //number_format($subtotal * option('tax_rate')/100, 2);
        
        $taxRate = json_decode(option('tax_rate'), true);
        
    	$total = $total + $shipping + $tax + $donation;

    	return view('cart::checkout.index')
                ->with('cartItems', $cartItems)
                ->with('subtotal', $subtotal)
                ->with('shipping', $shipping)
                ->with('tax', $tax)
                ->with('taxRate', $taxRate)
                ->with('donation', $donation)
                ->with('total', $total);
    }

    public function addToCart($productId)
    {
        $item = Product::find($productId);

        if ($item) 
        {
            $cart = Session::get('cart');

            if (!$cart)
                $cart = array();

            if (!in_array($productId, $cart))
                array_push($cart, $productId);
            
            Session::put('cart', $cart);

            return redirect()->route('cart.checkout');
        }
        else
        {
            return redirect()->back();
        }
    }

    public function addToCartbyForm(Request $request)
    {
        $item = Product::find($request->get('product_id'));
        $quantity = $request->get('quantity');
        $found = false;

        if ($item) 
        {
            $cart = Session::get('cart', array());
            
            $cart = json_decode(json_encode($cart), true);

            if (count($cart) > 0)
            {
                //Log::info('Cart: '. json_encode($cart));

                for ($i=0;$i<count($cart);$i++) { 
                    Log::info('inside first loop');
                     foreach($cart[$i] as $key => $value) {
                        //Log::info('inside second loop');
                        //Log::info('key: '.$key.' item->id: '.$item->id);

                        if ($key == $item->id) {
                            $found = true;
                            $cart[$i][$key] = $value+$quantity;
                            Log::info('cart after adding with updated quantity:'.json_encode($cart));
                            break;
                        }
                    }

                    if ($found)
                        break;
                }
            }
            
            if (!$found)
                array_push($cart, [$item->id => $quantity]);
            
            Session::put('cart', $cart);
        }
       
        return redirect()->back();
    }

    public function removeFromCart($productId)
    {
        $item = Product::find($productId);

        if ($item) 
        {
            $cart = Session::get('cart');
            $cart = json_decode(json_encode($cart), true);

            for ($i=0;$i<count($cart);$i++) { 
                Log::info('inside first loop');
                 foreach($cart[$i] as $key => $value) {
                    Log::info('inside second loop');
                    if ($key == $productId) {
                        Log::info('cart before removing:'.json_encode($cart));
                        //unset($cart[$i]);
                        array_splice($cart, $i, 1);
                        Log::info('cart after removing:'.json_encode($cart));
                        Session::put('cart', $cart);
                    }
                }
            }
                
        }
        
        return redirect()->route('cart.checkout');
        
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->back();
    }

}
