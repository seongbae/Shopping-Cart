<?php

return [

    'name' => 'Cart',

    'slug'=> 'cart',

    'description' => 'Cart module',

    'service_provider' => 'CartServiceProvider',

    'admin_menus' => [
    			'group'=> [
	    					'name'=>'Store',
	    					'url'=>'admin/store*',
			    			'icon'=>'fas fa-store'
			    		],
    			'index'=> [
    			 			'name'=>'Catalog',
    			 			'url'=>'admin/store/products',
			    			'icon'=>'fas fa-tag'
		    			],
                'new'=> [
    						'name'=>'Add New',
			    			'url'=>'admin/store/products/create',
			    			'icon'=>'fas fa-plus'
		    			],
                'related'=> [
                    'name'=>'Orders',
                    'url'=>'admin/store/orders',
                    'icon'=>'fas fa-file-invoice-dollar'
                ],
                
    ],
    
    'permissions' => [
    			'manage-cart'
    ],

    'options' => [
                [
                    'name'=>'Enable Checkout',
                    'slug'=>'checkout_enabled',
                    'type'=>'checkbox',
                    'default'=>false
                ],
                [
                    'name'=>'Shipping Amount',
                    'slug'=>'shipping_amount',
                    'type'=>'number',
                    'default'=>0
                ],
                [
                    'name'=>'Tax Rate (%)',
                    'slug'=>'tax_rate',
                    'type'=>'text',
                    'default'=>'{"VA":5,"MD":10}'
                ],
                [
                    'name'=>'Stripe Public Key',
                    'slug'=>'stripe_public_key',
                    'type'=>'text'
                ],
                [
                    'name'=>'Stripe Private Key',
                    'slug'=>'stripe_private_key',
                    'type'=>'text'
                ],
    ]

];