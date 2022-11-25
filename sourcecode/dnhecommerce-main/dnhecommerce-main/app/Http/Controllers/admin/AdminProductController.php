<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\Product;
use App\Models\admin\RelatedProduct;
use App\Models\admin\Supplier;
use App\Models\admin\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();
        $suppliers = Supplier::orderBy('created_at')->get();
        $taxs = Tax::orderBy('created_at')->get();
        $categorys = Category::orderBy('created_at')->get();
        $relateds = RelatedProduct::orderBy('created_at')->get();

        $countProduct = DB::table('product')->count();
        $countProductSoldOut = DB::table('product')->where('quantity', 0)->count();
        $countProductHidden = DB::table('product')->where('quantity', 0)->count();

        return view('admin.product.list', [
            'products' => $products,
            'suppliers' => $suppliers,
            'taxs' => $taxs,
            'relateds' => $relateds,
            'categorys' => $categorys,
            'countProduct' => $countProduct,
            'countProductSoldOut' => $countProductSoldOut,
            'countProductHidden' => $countProductHidden,
        ]);
    }

    public function createProduct()
    {
        $suppliers = Supplier::orderBy('created_at')->get();
        $taxs = Tax::orderBy('created_at')->get();
        $categorys = Category::orderBy('created_at')->get();
        $relateds = RelatedProduct::orderBy('created_at')->get();

        return view('admin.product.product-new', [
            'suppliers' => $suppliers,
            'taxs' => $taxs,
            'relateds' => $relateds,
            'categorys' => $categorys,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->file('image')) {
            $images = array();
            $count = 0;

            foreach ($request->file('image') as $file) {
                $count++;
                $imageName = (time() + $count) . '.' . $file->extension();
                $file->move(public_path('images/product/'), $imageName);
                $images[] = $imageName;
            }

            $product = new Product();
            $product->id_supplier = $request->input('id_supplier');
            $product->id_tax = $request->input('id_tax');
            $product->id_category = $request->input('id_category');
            $product->id_related = $request->input('id_related');
            $product->name = $request->input('name');
            $product->image = implode(",", $images);
            $product->quantity = $request->input('quantity');
            $product->cost = $request->input('cost');
            $product->price = $request->input('price');
            if (isset($request->active_sale)) {
                $product->active_sale = $request->input('active_sale');
            }

            if (isset($request->active_purchase)) {
                $product->active_purchase = $request->input('active_purchase');
            }
            $product->note = $request->input('note');
            $product->save();
        }
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);

        $product->id_supplier = $request->input('id_supplier');
        $product->id_tax = $request->input('id_tax');
        $product->id_category = $request->input('id_category');
        $product->id_related = $request->input('id_related');
        $product->name = $request->input('name');

        if ($request->file('image')) {
            $images = array();
            $count = 0;

            foreach ($request->file('image') as $file) {
                $count++;
                $imageName = (time() + $count) . '.' . $file->extension();
                $file->move(public_path('images/product/'), $imageName);
                $images[] = $imageName;
            }

            $product->image = implode(",", $images);
        }

        $product->quantity = $request->input('quantity');
        $product->cost = $request->input('cost');
        $product->price = $request->input('price');

        if (isset($request->active_sale)) {
            $product->active_sale = $request->input('active_sale');
        } else {
            $product->active_sale = 0;
        }

        if (isset($request->active_purchase)) {
            $product->active_purchase = $request->input('active_purchase');
        } else {
            $product->active_purchase = 0;
        }

        $product->note = $request->input('note');
        $product->save();
    }

    public function trash($id)
    {
        $product = Product::find($id);
        $product->active = 0;
        $product->save();
    }

    public function deleteAll()
    {
        DB::table('product')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
    }

    public function restoreAll()
    {
        DB::table('product')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $product = Product::find($id);
        $product->active = 1;
        $product->save();
    }

    public function handleCrudProduct(Request $request)
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

        return redirect()->route('admin.product');
    }
}
