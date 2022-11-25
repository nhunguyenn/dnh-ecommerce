<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductToLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductToLayoutController extends Controller
{
    public function index()
    {
        $banners = ProductToLayout::orderBy('created_at')->get();
        $products = Product::orderBy('created_at')->get();
        $countBanner = DB::table('product_to_layout')->count();

        return view('admin.advertisement.banner', [
            'banners' => $banners,
            'products' => $products,
            'countBanner' => $countBanner,
        ]);
    }

    public function create(Request $request)
    {
        ProductToLayout::create($request->all());
    }

    public function update(Request $request)
    {
        $banner = ProductToLayout::find($request->id);
        $banner->id_product = $request->input('id_product');
        $banner->note = $request->input('note');
        $banner->save();
    }

    public function delete($id)
    {
        $banner = ProductToLayout::find($id);
        $banner->delete();
    }

    public function handleCrudBanner(Request $request)
    {
        if ($request->button == "create") {
            self::create($request);
        }

        if ($request->button == "update") {
            self::update($request);
        }

        if ($request->button == "delete") {
            self::delete($request->input('id'));
        }

        return redirect()->route('admin.advertisement.banner');
    }
}
