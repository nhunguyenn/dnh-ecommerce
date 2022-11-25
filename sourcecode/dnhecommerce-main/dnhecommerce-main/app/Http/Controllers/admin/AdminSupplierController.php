<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Supplier;
use Illuminate\Support\Facades\DB;

class AdminSupplierController extends Controller
{
    public function list()
    {
        $suppliers = Supplier::orderBy('created_at')->get();
        $countActive = DB::table('supplier')->where('active', 1)->count();
        $countHidden = DB::table('supplier')->where('active', 0)->count();

        return view('admin.supplier.list', [
            'suppliers' => $suppliers,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        Supplier::create($request->all());
    }

    public function update(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->name = $request->input('name');
        $supplier->phone = $request->input('phone');
        $supplier->email = $request->input('email');
        $supplier->address = $request->input('address');
        $supplier->bank_name = $request->input('bank_name');
        $supplier->bank_number = $request->input('bank_number');
        $supplier->note = $request->input('note');
        $supplier->save();
    }

    public function trash($id)
    {
        $supplier = Supplier::find($id);
        $supplier->active = 0;
        $supplier->save();
    }

    public function deleteAll()
    {
        DB::table('supplier')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
    }

    public function restoreAll()
    {
        DB::table('supplier')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $supplier = Supplier::find($id);
        $supplier->active = 1;
        $supplier->save();
    }

    public function handleCrudSupplier(Request $request)
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

        return redirect()->route('admin.supplier.list');
    }
}
