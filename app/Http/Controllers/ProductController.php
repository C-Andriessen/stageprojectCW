<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(20);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $products = Product::orderByDesc('created_at')->where('id', '!=', $product->id)->take(4)->get();
        return view('products.single', compact('product', 'products'));
    }

    public function adminIndex()
    {
        $this->authorize('isAdmin', User::class);
        $products = Product::orderByDesc('created_at')->paginate(30);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price_excl = $request->price_excl;
        $product->vat = $request->vat;
        $product->discount_price = $request->discount_price;
        $imageName = time() . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('product_images'), $imageName);
        $product->image = $imageName;
        $product->save();
        return redirect(route('admin.products.index'))->with('status', 'Product is toegevoegd');
    }

    public function edit(Product $product)
    {
        $this->authorize('isAdmin', User::class);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price_excl = $request->price_excl;
        $product->vat = $request->vat;
        $product->discount_price = $request->discount_price;
        if ($request->image)
        {
            unlink(public_path('/product_images/' . $product->image));
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('product_images'), $imageName);
            $product->image = $imageName;
        }
        $product->save();
        return redirect(route('admin.products.index'))->with('status', 'Product is bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $this->authorize('isAdmin', User::class);
        unlink(public_path('/product_images/' . $product->image));
        $product->delete();
        return redirect(route('admin.products.index'))->with('status', 'Product is verwijderd');
    }
}
