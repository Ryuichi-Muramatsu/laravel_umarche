<?php

public function checkout()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
 
        $lineItems = [];
        foreach($products as $product) {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
 
            if($product->pivot->quantity > $quantity){
                return redirect()->route('user.cart.index');
            } else {
                $stripe_products = $stripe->products->create([
                    'name' => $product->name,
                    'description' => $product->information,
                ]);
                $stripe_price = $stripe->prices->create([
                    'product' => $stripe_products,
                    'unit_amount' => $product->price,
                    'currency' => 'jpy',
                ]);
                $lineItem = [
                    'price' => $stripe_price,
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }
        // dd($lineItems);
        // ストライプに渡す前に在庫を減らす
        foreach($products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1,
            ]);
        }
 
        $session = $stripe->checkout->sessions->create([
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.items.index'),
            'cancel_url' => route('user.cart.index'),
        ]);
 
        $publicKey = env('STRIPE_PUBLIC_KEY');
 
        return view('user.checkout', compact('session', 'publicKey'));
    }