<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessoryRequest;
use App\Http\Requests\UpdateAccessoryRequest;
use App\Models\Accessory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function store(StoreAccessoryRequest $request, Product $product)
    {
        $accessory = new Accessory;
        $accessory->name = $request->accessoryName;
        $accessory->price = $request->accessoryPrice;
        $accessory->discount_price = $request->accessoryDiscount_price;
        $accessory->vat = $request->accessoryVat;
        $accessory->category_id = $request->accessoryCategory;
        $accessory->product_id = $product->id;
        $accessory->save();
        return redirect()->route('admin.products.edit', $product)->with('status', 'Accessoire is toegevoegd');
    }

    public function update(UpdateAccessoryRequest $request, Product $product, Accessory $accessory)
    {
        $accessory->name = $request->input('name' . $accessory->id);
        $accessory->price = $request->input('price' . $accessory->id);
        $accessory->discount_price = $request->input('discount_' . $accessory->id);
        $accessory->vat = $request->input('vat' . $accessory->id);
        $accessory->category_id = $request->input('category' . $accessory->id);
        $accessory->save();
        return redirect()->route('admin.products.edit', $product)->with('status', 'Accessoire is aangepast');
    }

    public function destroy(Product $product, Accessory $accessory)
    {
        $this->authorize('isAdmin', User::class);
        $accessory->delete();
        return redirect()->route('admin.products.edit', $product)->with('status', 'Accessoire is verwijderd');
    }
}
