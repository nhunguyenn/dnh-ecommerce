<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\RelatedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRelatedProductController extends Controller
{
    public function index()
    {
        $relateds = RelatedProduct::orderBy('created_at')->get();
        $categorys = Category::orderBy('created_at')->get();
        $countActive = DB::table('related_product')->where('active', 1)->count();
        $countHidden = DB::table('related_product')->where('active', 0)->count();

        return view('admin.advertisement.related', [
            'relateds' => $relateds,
            'categorys' => $categorys,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        $related_category = $request->input('related_category');
        $related_category = implode(',', $related_category);

        $input = $request->except('related_category');
        $input['related_category'] = $related_category;

        RelatedProduct::create($input);
    }

    public function update(Request $request)
    {
        $related_category = $request->input('related_category');
        $related_category = implode(',', $related_category);

        $input = $request->except('related_category');
        $input['id'] = $request->input('id');
        $input['related_category'] = $related_category;

        $id = $input['id'];
        $name = $input['name'];
        $related_category = $input['related_category'];
        $note = $input['note'];

        DB::table('related_product')
            ->where('id', $id)
            ->update([
                'name' => $name,
                'related_category' => $related_category,
                'note' => $note,
            ]);
    }

    public function trash($id)
    {
        $related = RelatedProduct::find($id);
        $related->active = 0;
        $related->save();
    }

    public function deleteAll()
    {
        DB::table('related_product')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $related = RelatedProduct::find($id);
        $related->delete();
    }

    public function restoreAll()
    {
        DB::table('related_product')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $related = RelatedProduct::find($id);
        $related->active = 1;
        $related->save();
    }

    public function handleCrudRelatedProduct(Request $request)
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

        return redirect()->route('admin.advertisement.related');
    }
}
