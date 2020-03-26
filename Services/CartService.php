<?php

namespace App\Modules\Cart\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Modules\Cart\Models\Order;
use App\Modules\Cart\Models\Product;
use App\Modules\Cart\Models\OrderItem;
use App\Modules\Cart\Mail\ItemPurchased;
use App\Modules\Cart\Mail\OrderShipped;

class CartService
{

    public function createOrder($token, $firstName, $lastName, $email, $phone, $street, $street2, $city, $state, $zip, $ccName, $ccLast4, $subtotal, $tax, $shipping, $total, $userId, $orderItems, $donation, $notes=null )
    {

            try {
                Stripe::setApiKey(option('stripe_private_key'));

                if (isset($token)) {
                    $orderNum = $this->random_integer(6);

                    $intent = \Stripe\PaymentIntent::create([
                        'payment_method' => $token,
                        'amount' => $total*100,
                        'currency' => 'usd',
                        //'confirmation_method' => 'manual',
                        'confirm' => true,
                        'description' => 'Order:'. $orderNum,
                        'metadata' => [
                            'order_id' => $orderNum,
                            'donation_amount' => $donation
                          ],
                    ]);

                    Log::info(json_encode($intent));

                    if ($intent->status == 'succeeded')
                        $status = 'paid';
                    else
                        $status = 'ordered';

                    $ccLast4 = $intent->charges->data[0]->payment_method_details->card->last4;
            
                    // $intent = \Stripe\PaymentIntent::retrieve(
                    //     $token
                    // );

                    // $intent->confirm();


                    //$order = $this->saveOrder($firstName, $lastName, $email, $street, $street2, $city, $state, $zip, $ccName, $ccLast4, $subtotal, $tax, $shipping, $total, $userId, $status, $notes, $orderNum, $orderItems);
                    $order = new Order;
                    $order->order_number = $orderNum;
                    $order->first_name = $firstName;
                    $order->last_name = $lastName;
                    $order->email = $email;
                    $order->phone = $phone;
                    $order->street = $street;
                    $order->street2 = $street2;
                    $order->city = $city;
                    $order->state = $state;
                    $order->zip = $zip;
                    $order->cc_name = $ccName;
                    $order->cc_last4 = $ccLast4;
                    $order->subtotal = $subtotal;
                    $order->tax = $tax;
                    $order->shipping = $shipping;
                    $order->total = $total;
                    $order->status = $status;
                    $order->notes = $notes;
                    $order->user_id = $userId;
                    $order->save();

                    foreach($orderItems as $item)
                    {
                        $orderItem = new OrderItem;
                        $orderItem->order_id = $order->id;
                        $orderItem->product_id = $item['product_id'];
                        $orderItem->quantity = $item['quantity'];
                        $orderItem->price = $item['price']*$item['quantity'];
                        $orderItem->save();
                    }

                    Mail::to($email, $firstName. ' '.$lastName)
                        ->bcc($this->addressToArray(option('notification_email')))
                        ->send(new ItemPurchased($order));

                    return $order;
                }
                //$this->generateResponse($intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                # Display error on client
                Log::info(json_encode([
                  'error' => $e->getMessage()
                ]));
            }   

    	
    }

    public function createProduct($name, $price, $description = null)
    {
        return Product::create(['name'=>$name, 'price'=>$price, 'description'=>$description]);
    }

    public function updateShipping($orderId, $carrier, $code, $labelCreated, $shipped, $notify)
    {
        $order = Order::find($orderId);
        $order->shipping_carrier = $carrier;
        $order->shipping_code = $code;
        $order->shipped = $shipped;
        $order->label_created = $labelCreated;
        $order->save();

        if ($notify)
            Mail::to($order->email, $order->first_name. ' '.$order->last_name)
                        ->send(new OrderShipped($order));

        
        return $order;
    }

    private function addressToArray($emails)
    {
        if( strpos($emails, ',') !== false ) 
            return explode(",",$emails);
        elseif( strpos($emails, ';') !== false ) 
            return explode(";",$emails);
        else
            return $emails;

    }
    
    // private function saveOrder($orderItems)
    // {
    //     $order = new Order;
    //     $order->order_number = $orderNum;
    //     $order->first_name = $firstName;
    //     $order->last_name = $lastName;
    //     $order->email = $email;
    //     $order->street = $street;
    //     $order->street2 = $street2;
    //     $order->city = $city;
    //     $order->state = $state;
    //     $order->zip = $zip;
    //     $order->cc_name = $ccName;
    //     $order->cc_last4 = $ccLast4;
    //     $order->subtotal = $subtotal;
    //     $order->tax = $tax;
    //     $order->shipping = $shipping;
    //     $order->total = $total;
    //     $order->status = $status;
    //     $order->notes = $notes;
    //     $order->user_id = $userId;
    //     $order->save();

    //     foreach($orderItems as $item)
    //     {
    //         $orderItem = new OrderItem;
    //         $orderItem->order_id = $order->id;
    //         $orderItem->product_id = $item['product_id'];
    //         $orderItem->quantity = $item['quantity'];
    //         $orderItem->price = $item['price'];
    //         $orderItem->save();
    //     }

    //     return $order;

    // }

    private function random_strings($length_of_string) 
    { 
      
        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
      
        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result),  
                           0, $length_of_string); 
    } 

    private function random_integer($length_of_string) 
    { 
      
        // String of all alphanumeric character 
        $str_result = '0123456789'; 
      
        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($str_result),  
                           0, $length_of_string); 
    } 

}