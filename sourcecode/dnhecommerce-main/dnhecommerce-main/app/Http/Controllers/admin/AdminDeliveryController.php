<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDeliveryController extends Controller
{
    public function index()
    {
        $deliverys = Delivery::orderBy('created_at')->get();
        $countActive = DB::table('delivery')->where('active', 1)->count();
        $countHidden = DB::table('delivery')->where('active', 0)->count();

        return view('admin.delivery.index', [
            'deliverys' => $deliverys,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function create(Request $request)
    {
        Delivery::create($request->all());
    }

    public function update(Request $request)
    {
        $delivery = Delivery::find($request->id);
        $delivery->name = $request->input('name');
        $delivery->phone = $request->input('phone');
        $delivery->price = $request->input('price');
        $delivery->note = $request->input('note');
        $delivery->save();
    }

    public function trash($id)
    {
        $delivery = Delivery::find($id);
        $delivery->active = 0;
        $delivery->save();
    }

    public function deleteAll()
    {
        DB::table('delivery')->where('active', 0)->delete();
    }

    public function delete($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();
    }

    public function restoreAll()
    {
        DB::table('delivery')->where('active', 0)->update(['active' => 1]);
    }

    public function restore($id)
    {
        $delivery = Delivery::find($id);
        $delivery->active = 1;
        $delivery->save();
    }

    public function handleCrudDelivery(Request $request)
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

        return redirect()->route('admin.delivery');
    }
}
