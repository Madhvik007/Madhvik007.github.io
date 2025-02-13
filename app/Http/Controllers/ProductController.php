<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // ✅ Public product listing (Normal users can view products but not edit/delete)
    public function publicIndex()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    // ✅ Admin product listing (Admins can manage products)
    public function index()
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }

        $products = Product::orderBy('id', 'desc')->get();
        $total = Product::count();
        return view('admin.product.home', compact(['products', 'total']));
    }

    // ✅ Only admins can create products
    public function create()
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }
        return view('admin.product.create');
    }

    // ✅ Only admins can save products
    public function save(Request $request)
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }

        $validation = $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|integer',
        ]);

        $data = Product::create($validation);

        if ($data) {
            session()->flash('success', 'Product Added Successfully');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Some problem occurred');
            return redirect(route('admin/products/create'));
        }
    }

    // ✅ Only admins can edit products
    public function edit($id)
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }

        $products = Product::findOrFail($id);
        return view('admin.product.update', compact('products'));
    }

    // ✅ Only admins can update products
    public function update(Request $request, $id)
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }

        $products = Product::findOrFail($id);

        $products->title = $request->title;
        $products->category = $request->category;
        $products->price = $request->price;

        if ($products->save()) {
            session()->flash('success', 'Product Updated Successfully');
            return redirect(route('admin/products'));
        } else {
            session()->flash('error', 'Some problem occurred');
            return redirect(route('admin/products/edit', $id));
        }
    }

    // ✅ Only admins can delete products
    public function delete($id)
    {
        if (!Auth::user() || Auth::user()->usertype !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized Access');
        }

        $product = Product::findOrFail($id);

        if ($product->delete()) {
            session()->flash('success', 'Product Deleted Successfully');
        } else {
            session()->flash('error', 'Product Not Deleted Successfully');
        }

        return redirect()->route('admin/products');
    }
}
