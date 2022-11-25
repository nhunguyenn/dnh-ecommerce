<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTaxController extends Controller
{
    public function index()
    {
        $taxs = Tax::orderBy('created_at')->get();
        $countActive = DB::table('tax')->where('active', 1)->count();
        $countHidden = DB::table('tax')->where('active', 0)->count();

        return view('admin.tax.index', [
            'taxs' => $taxs,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        Tax::create($request->all());
    }

    public function update(Request $request)
    {
        $tax = Tax::find($request->id);
        $tax->name = $request->input('name');
        $tax->value = $request->input('value');
        $tax->type = $request->input('type');
        $tax->note = $request->input('note');
        $tax->save();
    }

    public function trash($id)
    {
        $tax = Tax::find($id);
        $tax->active = 0;
        $tax->save();
    }

    public function deleteAll()
    {
        DB::table('tax')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $tax = Tax::find($id);
        $tax->delete();
    }

    public function restoreAll()
    {
        DB::table('tax')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $tax = Tax::find($id);
        $tax->active = 1;
        $tax->save();
    }

    public function handleCrudTax(Request $request)
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

        return redirect()->route('admin.tax');
    }
}
