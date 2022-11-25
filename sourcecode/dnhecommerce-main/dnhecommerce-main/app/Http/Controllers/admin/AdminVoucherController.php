<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at')->get();
        $countActive = DB::table('voucher')->where('active', 1)->count();
        $countHidden = DB::table('voucher')->where('active', 0)->count();

        return view('admin.voucher.index', [
            'vouchers' => $vouchers,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        Voucher::create($request->all());
    }

    public function update(Request $request)
    {
        $voucher = Voucher::find($request->id);
        $voucher->name = $request->input('name');
        $voucher->price = $request->input('price');
        $voucher->total_product = $request->input('total_product');
        $voucher->note = $request->input('note');
        $voucher->save();
    }

    public function trash($id)
    {
        $voucher = Voucher::find($id);
        $voucher->active = 0;
        $voucher->save();
    }

    public function deleteAll()
    {
        DB::table('voucher')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $voucher = Voucher::find($id);
        $voucher->delete();
    }

    public function restoreAll()
    {
        DB::table('voucher')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $voucher = Voucher::find($id);
        $voucher->active = 1;
        $voucher->save();
    }

    public function handleCrudVoucher(Request $request)
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

        return redirect()->route('admin.voucher');
    }
}
