<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSizeAttributesController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at')->get();
        $sizes = ProductSize::orderBy('created_at')->get();

        $countActive = DB::table('product_size')->where('active', 1)->count();
        $countHidden = DB::table('product_size')->where('active', 0)->count();

        return view('admin.attributes.size', [
            'products' => $products,
            'sizes' => $sizes,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        ProductSize::create($request->all());
    }

    public function update(Request $request)
    {
        $size = ProductSize::find($request->id);
        $size->id_product = $request->input('id_product');
        $size->name = $request->input('name');
        $size->quantity = $request->input('quantity');
        $size->note = $request->input('note');
        $size->save();
    }

    public function trash($id)
    {
        $size = ProductSize::find($id);
        $size->active = 0;
        $size->save();
    }

    public function deleteAll()
    {
        DB::table('product_size')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $size = ProductSize::find($id);
        $size->delete();
    }

    public function restoreAll()
    {
        DB::table('product_size')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $size = ProductSize::find($id);
        $size->active = 1;
        $size->save();
    }

    public function handleCrudSizeAttributes(Request $request)
    {
        if ($request->button == "create") {
            self::create($request);
        }

        if ($request->button == "update") {
            self::update($request);
        }

        if ($request->button == "trash") {
            self::trash($request->input('id'));
        }

        if ($request->button == "deleteAll") {
            self::deleteAll();
        }

        if ($request->button == "delete") {
            self::delete($request->input('id'));
        }

        if ($request->button == "restoreAll") {
            self::restoreAll();
        }

        if ($request->button == "restore") {
            self::restore($request->input('id'));
        }


        return redirect()->route('admin.attributes.size');
    }
}
