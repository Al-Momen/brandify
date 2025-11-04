<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $query = Category::latest();

        switch ($status) {
            case 'disable':
                $query->where('status', Status::DISABLE);
                break;
            case 'enable':
                $query->where('status', Status::ENABLE);
                break;
            case 'all':
                $query->whereIn('status', [Status::ENABLE, Status::DISABLE]);
                break;
            default:
                break;
        }

        if ($search) {
            $query->searchable(['name']);
        }
        $categories = $query->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Categories';
        return view('Admin::category.index', compact('categories', 'pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])]
        ]);

        $category = new Category();
        $category->name = $request->name;
        if ($request->hasFile('image')) {
            try {
                $category->image = fileUploader($request->image, getFilePath('category'), getFileSize('category'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $category->status = isset($request->status) ? 1 : 0;
        $category->save();

        $notify[] = ['success', 'Category has been created successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:60',
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])]
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = isset($request->catstatus) ? 1 : 0;
        $category->save();
        $notify[] = ['success', 'Category has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();
        $notify[] = ['success', 'Category Status has been updated successfully'];
        return back()->withNotify($notify);
    }
}
