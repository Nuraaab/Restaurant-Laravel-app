<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('per_page', 10); 
    $query = Category::query();
    if (!empty($search)) {
        $query->where('name', 'like', "%$search%");
    }
    $data['categories'] = $query->orderBy('id', 'DESC')->paginate($perPage);
    $data['search'] = $search;
    $data['perPage'] = $perPage;
    return view('menu-management.categories.index', $data);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slug = rawurlencode(make_slug($request->name));
        $check_category = Category::where('slug', $slug)->first();
        if (!empty($check_category)) {
            Session::flash('warning', 'The Category has already Taken!');
            return "success";
        }

        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
        ];
        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpeg,png,svg,jpg';
            $messages = [
                'image.mimes' => 'Only jpeg,png,svg,jpg files are allowed'
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $data = new Category;
        $input = $request->all(); 
        $input['slug'] =  $slug;

        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('assets/admin/img/categories/'), $name);
            $input['image'] = $name;
        }
        $data->create($input);

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('menu-management.categories.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $messages = [];
        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'mimes:jpeg,png,svg,jpg';
            $messages = [
                'image.mimes' => 'Only jpeg,png,svg,jpg files are allowed'
            ];
        }
        
        $slug = rawurlencode(make_slug($request->name));
        $check_category = Category::where('slug', $slug)->first();
        if (!empty($check_category)) {
            if ($check_category->id != $request->category_id) {
                Session::flash('warning', 'The Category has already Taken!');
                return "success";
            }
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $data = Category::findOrFail($request->category_id);
        $input = $request->all();
        $input['slug'] =  $slug;

        if ($request->hasFile('image')) {
            @unlink(public_path('assets/admin/img/categories/' . $data->image));
            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('assets/admin/img/categories/'), $name);
            $input['image'] = $name;
        } else {
            $input['image'] =  $data->image;
        }
        $data->update($input);

        Session::flash('success', 'Category Update successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }

    public function delete(Request $request){
        $category = Category::findOrFail($request->category_id);
        if ($category->products()->count() > 0) {
            Session::flash('warning', 'First, delete all the products under the selected categories!');
            return back();
        }
        @unlink(public_path('assets/admin/img/categories/' . $category->image));
        $category->delete();
        Session::flash('success', 'Category deleted successfully!');
        return back();
    }
}
