<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use App\Mail\OfferMail;
use App\Mail\OrderMail;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\OrderAccessory;
use App\Models\OrdersProducts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        $this->authorize('isAdmin', User::class);
        $orders = Order::orderByDesc('created_at')->paginate(30);
        return view('admin.orders.index', compact('orders'));
    }

    public function clearSession()
    {
        $this->authorize('isAdmin', User::class);
        request()->session()->forget('customer');
        request()->session()->forget('products');
        return redirect(route('admin.orders.create.customer'));
    }

    public function createCustomer()
    {
        $this->authorize('isAdmin', User::class);
        $customer = request()->session()->get('customer');
        return view('admin.orders.create.customer', compact('customer'));
    }

    public function storeCustomer(StoreCustomerRequest $request)
    {
        if ($request->session()->has('customer'))
        {
            request()->session()->forget('customer');
        }
        $customerData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
        ];

        $request->session()->put('customer', $customerData);
        return redirect(route('admin.orders.create.products'));
    }

    public function productsAddCreate()
    {
        if (!request()->session()->has('customer'))
        {
            return redirect(route('admin.orders.create.customer'))->with('status', 'Je moet eerst de klantgegevens invullen!');
        }
        $this->authorize('isAdmin', User::class);
        $sessionProducts = request()->session()->get('products', []);
        $products = Product::orderBy('name')->get();
        foreach ($sessionProducts as $sessionProduct)
        {
            foreach ($products as $i => $product)
            {
                if ($product->is($sessionProduct["product"]))
                {
                    unset($products[$i]);
                }
            }
        }
        return view('admin.orders.create.products', compact('products', 'sessionProducts'));
    }

    public function productStoreCreate(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $product = Product::findOrFail($request->product);
        $products = $request->session()->get('products', []);
        if ($product->discount_price)
        {
            $products[] = ['product' => $product, 'quantity' => 1, 'discountPrice' => $product->discount_price];
        }
        else
        {
            $products[] = ['product' => $product, 'quantity' => 1, 'discountPrice' => 0];
        }
        $request->session()->put('products', $products);

        return redirect(route('admin.orders.create.products'))->with('status', 'Product is toegevoegd');
    }

    public function updateProductCreate(UpdateOrderProductRequest $request, Product $product)
    {
        $cartItems = $request->session()->get('products', []);
        foreach ($cartItems as $i => $cartItem)
        {
            if ($cartItem['product']->is($product))
            {
                $cartItems[$i] = ['product' => $product, 'quantity' => $request->quantity, 'discountPrice' => $request->discountPrice];
            }
        }
        $request->session()->forget('products');
        $request->session()->put('products', $cartItems);
        return redirect(route('admin.orders.create.products'))->with('status', 'Product is aangepast');
    }

    public function deleteProductCreate(Product $product)
    {
        $cartItems = request()->session()->get('products', []);
        foreach ($cartItems as $i => $cartItem)
        {
            if ($cartItem['product']->is($product))
            {
                unset($cartItems[$i]);
            }
        }
        request()->session()->forget('product');
        request()->session()->put('products', $cartItems);
        return redirect(route('admin.orders.create.products'))->with('status', 'Product is verwijderd');
    }

    public function confirmCreate()
    {
        $this->authorize('isAdmin', User::class);
        $customer = request()->session()->get('customer', []);
        if (!$customer)
        {
            return redirect(route('admin.orders.create.customer'))->with('status', 'Je moet eerst producten toevoegen');
        }
        $sessionProducts = request()->session()->get('products', []);
        if (!$sessionProducts)
        {
            return redirect(route('admin.orders.create.products'))->with('status', 'Je moet eerst producten toevoegen');
        }
        return view('admin.orders.create.confirm', compact('customer', 'sessionProducts'));
    }

    public function adminStore(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $subtotal = 0;
        $vat_total = 0;
        $total_amount = 0;
        $items =  $request->session()->get('products', []);

        foreach ($items as $item)
        {
            if ($item['discountPrice'])
            {
                $subtotal += $item['discountPrice'] * $item["quantity"];
                $vat_total += $item['discountPrice'] * $item["quantity"] * ($item['product']->vat / 100);
                $total_amount += ($item['discountPrice'] * $item["quantity"] * ($item['product']->vat / 100)) + ($item['discountPrice'] * $item['quantity']);
            }
            else
            {
                $subtotal += $item['product']->price_excl * $item["quantity"];
                $vat_total += $item['product']->price_excl * $item["quantity"] * ($item['product']->vat / 100);
                $total_amount += ($item['product']->price_excl * $item["quantity"] * ($item['product']->vat / 100)) + ($item['product']->price_excl * $item['quantity']);
            }
        }
        $customer = $request->session()->get('customer');
        $order = new Order;
        $order->customer_name = $customer['name'];
        $order->customer_email = $customer['email'];
        $order->customer_address = $customer['address'];
        $order->customer_city = $customer['city'];
        $order->customer_zip_code = $customer['zip_code'];
        $order->subtotal_excl = $subtotal;
        $order->vat_total = $vat_total;
        $order->total_amount = $total_amount;
        $order->status = $request->type;
        $order->save();

        foreach ($items as $item)
        {
            $orderProduct = new OrdersProducts;
            $orderProduct->product_id = $item["product"]->id;
            $orderProduct->order_id = $order->id;
            $orderProduct->quantity = $item["quantity"];
            $orderProduct->vat = $item["product"]->vat;
            $orderProduct->price_excl = $item["product"]->price_excl;
            $orderProduct->discount_price = $item["discountPrice"];
            $orderProduct->save();
        }

        $products = OrdersProducts::where('order_id', $order->id)->get();
        if ($request->send)
        {
            if ($request->type == Order::FACTUUR)
            {
                Mail::to($customer["email"])->send(new OrderShipped($order, $products));
            }
            else if ($request->type == Order::OFFERTE)
            {
                Mail::to($customer["email"])->send(new OfferMail($order, $products));
            }
            else
            {
                Mail::to($customer["email"])->send(new OrderMail($order, $products));
            }
        }
        $request->session()->forget('products');
        $request->session()->forget('customer');
        return redirect(route('admin.orders.index'))->with('status', 'Order is aangemaakt');
    }

    public function changeStatus(Request $request, Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $order->status = $request->type;
        $order->save();
        switch ($order->status)
        {
            case Order::FACTUUR:
                return redirect(route('admin.orders.edit.index', $order))->with('status', 'Bestelling is omgezet naar factuur');
                break;
            case Order::OFFERTE:
                return redirect(route('admin.orders.edit.index', $order))->with('status', 'Bestelling is omgezet naar offerte');
                break;
            case Order::BESTELLING:
                return redirect(route('admin.orders.edit.index', $order))->with('status', 'Bestelling is omgezet naar bestelling');
                break;
        }
    }

    public function order(Request $request)
    {
        $items = $request->session()->get('products');
        $subtotal = 0;
        $vat_total = 0;
        $total_amount = 0;
        foreach ($items as $item)
        {
            if ($item["product"]->discount_price)
            {
                $subtotal += ($item["product"]->discount_price * $item["quantity"]);
                $vat_total += ($item["product"]->discount_price * $item["quantity"] * ($item["product"]->vat / 100));
            }
            else
            {
                $subtotal += ($item["product"]->price_excl * $item["quantity"]);
                $vat_total += ($item["product"]->price_excl * $item["quantity"] * ($item["product"]->vat / 100));
            }
        }
        $total_amount = $subtotal + $vat_total;
        $customer = $request->session()->get('customer');
        $order = new Order;
        $order->customer_name = $customer["name"];
        $order->customer_email = $customer["email"];
        $order->customer_address = $customer["address"];
        $order->customer_city = $customer["city"];
        $order->customer_zip_code = $customer["zip_code"];
        $order->subtotal_excl = $subtotal;
        $order->vat_total = $vat_total;
        $order->total_amount = $total_amount;
        $order->status = Order::BESTELLING;
        $order->save();

        foreach ($items as $item)
        {
            $orderProduct = new OrdersProducts;
            $orderProduct->product_id = $item["product"]->id;
            $orderProduct->order_id = $order->id;
            $orderProduct->quantity = $item["quantity"];
            $orderProduct->vat = $item["product"]->vat;
            $orderProduct->price_excl = $item["product"]->price_excl;
            $orderProduct->discount_price = $item["product"]->discount_price;
            $orderProduct->save();
        }
        $products = OrdersProducts::where('order_id', $order->id)->get();
        Mail::to($request->session()->get('customer')["email"])->send(new OrderMail($order, $products));
        session()->put('order', $order);
        $request->session()->pull('products');
        return $order;
    }

    public function edit(Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $products = OrdersProducts::where('order_id', $order->id)->get();
        $productsNew = Product::orderBy('name')->get();
        $productAccessories = OrderAccessory::where('order_id', $order->id)->get();
        foreach ($products as $product)
        {
            foreach ($productsNew as $i => $productNew)
            {
                if ($productNew->is($product->product))
                {
                    unset($productsNew[$i]);
                }
            }
        }
        return view('admin.orders.edit', compact('order', 'products', 'productsNew', 'productAccessories'));
    }

    public function downloadPDF(Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $products = OrdersProducts::where('order_id', $order->id)->get();
        $pdf = PDF::loadView('admin.orders.pdf', compact('order', 'products'));
        return $pdf->stream('ordernr' . $order->id . '.pdf');
    }

    public function update(StoreCustomerRequest $request, Order $order)
    {
        $order->customer_email = $request->email;
        $order->customer_name = $request->name;
        $order->customer_address = $request->address;
        $order->customer_zip_code = $request->zip_code;
        $order->customer_city = $request->city;
        $order->save();
        return redirect(route('admin.orders.index'))->with('status', 'Order is bijgewerkt');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('admin.orders.index'))->with('status', 'Order is verwijderd');
    }
    public function mailOrder(Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $products = OrdersProducts::where('order_id', $order->id)->get();
        if ($order->status == Order::FACTUUR)
        {
            Mail::to($order->customer_email)->send(new OrderShipped($order, $products));
        }
        else if ($order->status == Order::OFFERTE)
        {
        }
        switch ($order->status)
        {
            case Order::FACTUUR:
                Mail::to($order->customer_email)->send(new OrderShipped($order, $products));
                break;

            case Order::OFFERTE:
                Mail::to($order->customer_email)->send(new OfferMail($order, $products));
                break;

            case Order::BESTELLING:
                Mail::to($order->customer_email)->send(new OrderMail($order, $products));
                break;
        }
        return redirect(route('admin.orders.edit.index', $order))->with('status', 'Email is verzonden');
    }
}
