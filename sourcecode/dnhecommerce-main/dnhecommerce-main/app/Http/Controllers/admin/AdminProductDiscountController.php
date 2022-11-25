<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductDiscountController extends Controller
{
    public function index(Request $request)
    {
        $product_discounts = ProductDiscount::orderBy('time_start')->get();
        $products = Product::orderBy('created_at')->get();

        $countPrductDiscount = DB::table('product_discount')->count();
        $countProductActive = DB::table('product_discount')->where('active', 1)->count();
        $countProductHidden = DB::table('product_discount')->where('active', 0)->count();

        return view('admin.product.discount', [
            'product_discounts' => $product_discounts,
            'products' => $products,
            'countPrductDiscount' => $countPrductDiscount,
            'countProductActive' => $countProductActive,
            'countProductHidden' => $countProductHidden,
        ]);
    }

    public function create(Request $request)
    {
        ProductDiscount::create($request->all());
    }

    public function update(Request $request)
    {
        $product_discount = ProductDiscount::find($request->id);
        $product_discount->id_product = $request->input('id_product');
        $product_discount->percent_discount = $request->input('percent_discount');
        $product_discount->quantity = $request->input('quantity');
        $product_discount->note = $request->input('note');

        if (isset($request->active)) {
            $product_discount->active = $request->input('active');
        } else {
            $product_discount->active = 0;
        }

        $product_discount->time_start = $request->input('time_start');
        $product_discount->time_end = $request->input('time_end');
        $product_discount->save();
    }

    public function handleCrudProductDiscount(Request $request)
    {
        if ($request->button == "create") {
            self::create($request);
        }

        if ($request->button == "update") {
            self::update($request);
        }

        return redirect()->route('admin.product.discount');
    }
}
