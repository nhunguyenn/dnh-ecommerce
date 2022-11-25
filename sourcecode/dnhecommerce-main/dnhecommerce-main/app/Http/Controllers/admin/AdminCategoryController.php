<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Category;
use App\Models\admin\ThemeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    // Theme

    public function indexTheme(Request $request)
    {
        $themes = ThemeList::orderBy('created_at')->get();
        $countActive = DB::table('theme_list')->where('active', 1)->count();
        $countHidden = DB::table('theme_list')->where('active', 0)->count();

        return view('admin.category.theme', [
            'themes' => $themes,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function createTheme(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/category/'), $imageName);

            $theme = new ThemeList();
            $theme->name = $request->input('name');
            $theme->image = $imageName;
            $theme->note = $request->input('note');
            $theme->save();
        }
    }

    public function updateTheme(Request $request)
    {
        $theme = ThemeList::find($request->id);

        if ($request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/category/'), $imageName);
            $theme->image = $imageName;
        }

        $theme->name = $request->input('name');
        $theme->note = $request->input('note');
        $theme->save();
    }

    public function trashTheme($id)
    {
        $theme = ThemeList::find($id);
        $theme->active = 0;
        $theme->save();
    }

    public function deleteAllTheme()
    {
        DB::table('theme_list')->where('active', 0)->delete();
    }

    public function deleteTheme($id)
    {
        $theme = ThemeList::find($id);
        $theme->delete();
    }

    public function restoreAllTheme()
    {
        DB::table('theme_list')->where('active', 0)->update(['active' => 1]);
    }

    public function restoreTheme($id)
    {
        $theme = ThemeList::find($id);
        $theme->active = 1;
        $theme->save();
    }

    public function handleCrudTheme(Request $request)
    {
        if ($request->button == "create") {
            self::createTheme($request);
        }

        if ($request->button == "update") {
            self::updateTheme($request);
        }

        if ($request->button == "trash") {
            self::trashTheme($request->input('id'));
        }

        if ($request->button == "deleteAll") {
            self::deleteAllTheme();
        }

        if ($request->button == "delete") {
            self::deleteTheme($request->input('id'));
        }

        if ($request->button == "restoreAll") {
            self::restoreAllTheme();
        }

        if ($request->button == "restore") {
            self::restoreTheme($request->input('id'));
        }

        return redirect()->route('admin.category.theme');
    }

    // Group

    public function indexGroup()
    {
        $categorys = Category::orderBy('created_at')->get();
        $themes = ThemeList::orderBy('created_at')->get();
        $countActive = DB::table('category')->where('active', 1)->count();
        $countHidden = DB::table('category')->where('active', 0)->count();

        return view('admin.category.group', [
            'categorys' => $categorys,
            'themes' => $themes,
            'countActive' => $countActive,
            'countHidden' => $countHidden,
        ]);
    }

    public function createGroup(Request $request)
    {
        Category::create($request->all());
    }

    public function updateGroup(Request $request)
    {
        $category = Category::find($request->id);
        $category->id_theme_list = $request->input('id_theme_list');
        $category->name = $request->input('name');
        $category->note = $request->input('note');
        $category->save();
    }

    public function trashGroup($id)
    {
        $category = Category::find($id);
        $category->active = 0;
        $category->save();
    }

    public function deleteAllGroup()
    {
        DB::table('category')->where('active', 0)->delete();
    }

    public function deleteGroup($id)
    {
        $category = Category::find($id);
        $category->delete();
    }

    public function restoreAllGroup()
    {
        DB::table('category')->where('active', 0)->update(['active' => 1]);
    }

    public function restoreGroup($id)
    {
        $category = Category::find($id);
        $category->active = 1;
        $category->save();
    }

    public function handleCrudGroup(Request $request)
    {
        if ($request->button == "create") {
            self::createGroup($request);
        }

        if ($request->button == "update") {
            self::updateGroup($request);
        }

        if ($request->button == "trash") {
            self::trashGroup($request->input('id'));
        }

        if ($request->button == "deleteAll") {
            self::deleteAllGroup();
        }

        if ($request->button == "delete") {
            self::deleteGroup($request->input('id'));
        }

        if ($request->button == "restoreAll") {
            self::restoreAllGroup();
        }

        if ($request->button == "restore") {
            self::restoreGroup($request->input('id'));
        }

        return redirect()->route('admin.category.group');
    }
}
