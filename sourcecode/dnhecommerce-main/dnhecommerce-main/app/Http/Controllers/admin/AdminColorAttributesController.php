<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Product;
use App\Models\admin\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminColorAttributesController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at')->get();
        $colors = ProductColor::orderBy('created_at')->get();

        $countActive = DB::table('product_color')->where('active', 1)->count();
        $countHidden = DB::table('product_color')->where('active', 0)->count();

        return view('admin.attributes.color', [
            'products' => $products,
            'colors' => $colors,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        ProductColor::create($request->all());
    }

    public function update(Request $request)
    {
        $color = ProductColor::find($request->id);
        $color->id_product = $request->input('id_product');
        $color->name = $request->input('name');
        $color->color_code = $request->input('color_code');
        $color->quantity = $request->input('quantity');
        $color->price = $request->input('price');
        $color->note = $request->input('note');
        $color->save();
    }

    public function trash($id)
    {
        $color = ProductColor::find($id);
        $color->active = 0;
        $color->save();
    }

    public function deleteAll()
    {
        DB::table('product_color')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $color = ProductColor::find($id);
        $color->delete();
    }

    public function restoreAll()
    {
        DB::table('product_color')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $color = ProductColor::find($id);
        $color->active = 1;
        $color->save();
    }

    public function handleCrudColorAttribute(Request $request)
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

        return redirect()->route('admin.attributes.color');
    }
}
