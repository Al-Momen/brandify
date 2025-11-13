<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Logo::with('logo_images', 'category', 'user')->latest();

        if ($search) {
            $query->searchable(['brand_name']);
        }

        $logos = $query->paginate(getPaginate());
        $pageTitle = 'All Logos';

        return view('Admin::logo.index', compact('logos', 'pageTitle'));
    }

    public function view($id)
    {
        $logo = Logo::with(['logo_images', 'category', 'user'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $logo,
        ]);
    }
}
