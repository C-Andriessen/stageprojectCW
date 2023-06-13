<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderProductRequest;
use App\Models\Order;
use App\Models\OrdersProducts;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersProductsController extends Controller
{
    public function add(Request $request, Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $product = Product::findOrFail($request->product);
        $orderProduct = new OrdersProducts;
        $orderProduct->product_id = $product->id;
        $orderProduct->order_id = $order->id;
        $orderProduct->quantity = 1;
        $orderProduct->vat = $product->vat;
        $orderProduct->price_excl = $product->price_excl;
        $orderProduct->discount_price = $product->discount_price;
        $orderProduct->save();
        $this->calculate($order);
        return redirect(route('admin.orders.edit.index', $order))->with('status', 'Product is toegevoegd');
    }
    public function discount(UpdateOrderProductRequest $request, Order $order, OrdersProducts $product)
    {

        $this->authorize('isAdmin', User::class);
        if ($product->price_excl < $request->discountPrice)
        {
            return redirect(route('admin.orders.edit.index', $order))->withErrors(['discountPrice' => 'Kortingsprijs mag niet hoger zijn dan de per stuk prijs']);
        }
        $product->discount_price = $request->discountPrice;
        $product->save();
        $this->calculate($order);
        return redirect(route('admin.orders.edit.index', $order))->with('status', 'Kortingsprijs is aangepast');
    }
    public function quantity(UpdateOrderProductRequest $request, Order $order, OrdersProducts $product)
    {
        $this->authorize('isAdmin', User::class);
        $product->quantity = $request->quantity;
        $product->save();
        $this->calculate($order);
        return redirect(route('admin.orders.edit.index', $order))->with('status', 'Aantal is aangepast');
    }
    public function destroy(Order $order, OrdersProducts $product)
    {
        $this->authorize('isAdmin', User::class);
        $product->delete();
        $orderProducts = OrdersProducts::where('order_id', $order->id)->get();
        if (count($orderProducts) == 0)
        {
            $order->delete();
            return redirect(route('admin.orders.index'))->with('status', 'Order is verwijderd samen met het laatste product');
        }
        else
        {
            $this->calculate($order);
            return redirect(route('admin.orders.edit.index', $order))->with('status', 'Product is verwijderd');
        }
    }

    private function calculate(Order $order)
    {
        $subtotal = 0;
        $vat_total = 0;
        $total = 0;
        $orderProducts = OrdersProducts::where('order_id', $order->id)->get();
        foreach ($orderProducts as $orderProduct)
        {
            if ($orderProduct->discount_price)
            {
                $subtotal += $orderProduct->discount_price * $orderProduct->quantity;
                $vat_total += $orderProduct->discount_price * $orderProduct->quantity * ($orderProduct->vat / 100);
            }
            else
            {
                $subtotal += $orderProduct->price_excl * $orderProduct->quantity;
                $vat_total += $orderProduct->price_excl * $orderProduct->quantity * ($orderProduct->vat / 100);
            }
        }
        $total = $subtotal + $vat_total;
        $order->subtotal_excl = $subtotal;
        $order->vat_total = $vat_total;
        $order->total_amount = $total;
        $order->save();
    }
}
