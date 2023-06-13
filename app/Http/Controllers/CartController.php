<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Accessory;
use App\Models\OrdersProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->session()->get('products') ?? [];
        rsort($items);
        if ($items)
        {
            $this->calculate($items);
        }
        $prices = $request->session()->get('prices', []);
        return view('cart.index', compact('items', 'prices'));
    }

    public function add(Request $request, Product $product)
    {
        $cartItems = session()->get('products', []);
        $accessories = [];
        foreach ($request->accessoires as $accessory)
        {
            $accessories[] = Accessory::where('id', $accessory)->firstOrFail();
        }
        $cartItems[] = [
            'product' => $product, 'quantity' => 1, 'accessories' => $accessories
        ];
        session()->forget('products');
        session()->put('products', $cartItems);
        return redirect(route('cart.index'))->with('status', 'Product toegevoegd aan winkelmandje');
    }

    public function customerData(Request $request)
    {
        if (!$request->session()->has('products'))
        {
            return redirect(route('cart.index'))->with('status', 'Je moet eerst producten toevoegen aan je winkelmand');
        }
        $items = $request->session()->get('products') ?? [];
        rsort($items);
        return view('cart.data', compact('items'));
    }

    public function storeCustomerData(StoreCustomerRequest $request)
    {
        if ($request->session()->has('customer'))
        {
            request()->session()->pull('customer');
        }
        $customerData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
        ];

        $request->session()->put('customer', $customerData);
        return redirect(route('cart.confirm'));
    }

    public function confirm(Request $request)
    {
        if (!$request->session()->has('products'))
        {
            return redirect(route('cart.index'))->with('status', 'Je kan geen bestelling plaatsen zonder producten');
        }
        if (!$request->session()->has('customer'))
        {
            return redirect(route('cart.data'))->with('status', 'Je moet eerst je gegevens invullen');
        }
        $customer = $request->session()->get('customer');
        $items = $request->session()->get('products');
        rsort($items);
        return view('cart.confirm', compact('customer', 'items'));
    }

    public function update(UpdateCartRequest $request, Product $product)
    {
        $cartItems = $request->session()->get('products');
        foreach ($cartItems as $i => $cartItem)
        {
            if ($cartItem['product']->is($product))
            {
                $cartItems[$i] = ['product' => $product, 'quantity' => $request->quantity, 'accessories' => $cartItem['accessories']];
            }
        }
        $request->session()->forget('products');
        $request->session()->put('products', $cartItems);
        return redirect(route('cart.index'));
    }

    public function destroy(Request $request, Product $product)
    {
        $cartItems = $request->session()->get('products');
        foreach ($cartItems as $i => $cartItem)
        {
            if ($cartItem['product']->is($product))
            {
                unset($cartItems[$i]);
            }
        }
        $request->session()->forget('product');
        $request->session()->put('products', $cartItems);
        return redirect(route('cart.index'))->with('status', 'Product verwijderd uit winkelmandje');
    }

    public function confirmed()
    {
        if (!session()->has('order'))
        {
            return redirect(route('cart.index'));
        }

        $order = session()->get('order');
        $products = OrdersProducts::where('order_id', $order->id)->get();
        return view('cart.confirmed', compact('products', 'order'));
    }

    private function calculate($items)
    {
        $subtotal = 0;
        $discount = 0;
        $vat = 0;
        $total = 0;
        foreach ($items as $item)
        {
            $subtotal += $item['product']->price_excl * $item['quantity'];
            $discount += $item['product']->price_excl - $item['product']->discount_price * $item['quantity'];
            $vat += $item['product']->discount_price ? $item['product']->discount_price * ($item['product']->vat / 100) * $item['quantity'] : $item['product']->discount_price * ($item['product']->price_excl / 100) * $item['quantity'];
            foreach ($item['accessories'] as $accessory)
            {
                $subtotal += $accessory->price * $item['quantity'];
                $discount += $accessory->price - $accessory->discount_price * $item['quantity'];
                $vat += $accessory->discount_price ? $accessory->discount_price * ($accessory->vat / 100) * $item['quantity'] : $accessory->price * ($accessory->vat / 100) * $item['quantity'];
            }
        }
        $discountedTotal = $subtotal - $discount;
        $total = $discountedTotal + $vat;
        $prices = [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'discountedTotal' => $discountedTotal,
            'vat' => $vat,
            'total' => $total,
        ];
        session()->put('prices', $prices);
    }
}
