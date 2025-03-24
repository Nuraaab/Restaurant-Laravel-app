<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\Uploader; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); 
        $query = Product::query();
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        $data['items'] = $query->orderBy('id', 'DESC')->paginate($perPage);
        $data['search'] = $search;
        $data['perPage'] = $perPage;
        return view('menu-management.items.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('menu-management.items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [];
        $rules = [];
        $thumbnailImgURL = $request->thumbnail;
        $sliderImgURLs = $request->has('image') ? $request->image : [];
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'svg');
        $thumbnailImgExt = $thumbnailImgURL ? $thumbnailImgURL->extension() : null;
        $sliderImgExts = [];

        $rules['image'] = [
            'required',
            function ($attribute, $value, $fail) use ($allowedExtensions, $sliderImgExts) {
                if (!empty($sliderImgExts)) {
                    foreach ($sliderImgExts as $sliderImgExt) {
                        if (!in_array($sliderImgExt, $allowedExtensions)) {
                            $fail('Only .jpg, .jpeg, .png and .svg file is allowed for slider image.');
                            break;
                        }
                    }
                }
            }
        ];
        $rules['thumbnail'] = [
            'required',
            function ($attribute, $value, $fail) use ($allowedExtensions, $thumbnailImgExt) {
                if (!in_array($thumbnailImgExt, $allowedExtensions)) {
                    $fail('Only .jpg, .jpeg, .png and .svg file is allowed for thumbnail image.');
                }
            }
        ];
        $messages['image.required'] = 'The slider Image is required.';
        $rules['status'] = 'required';
        $rules['price'] = 'required|numeric|min:0'; 
        $messages =[
            'price.min' => 'The price must be a positive value grater than or equal to 0',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        if (!empty($sliderImgURLs)) {
            foreach ($sliderImgURLs as $sliderImgURL) {
                $n = strrpos($sliderImgURL, ".");
                $extension = ($n === false) ? "" : substr($sliderImgURL, $n + 1);
                array_push($sliderImgExts, $extension);
            }
        }
        $categories = $request->category;
        $item = new Product();
        // set a name for the thumbnail image and store it to local storage
        $thumbnailImgName = time() . '.' . $thumbnailImgExt;
        $thumbnailDir = public_path('assets/admin/img/items/thumbnail/');
        @mkdir($thumbnailDir, 0775, true);
        @copy($thumbnailImgURL, $thumbnailDir . $thumbnailImgName);
        $sliderDir = public_path('assets/admin/img/items/slider-images/');
        @mkdir($sliderDir, 0775, true);

        $item->name = $request->name;
        $item->description = $request->description;
        $item->slug = $this->generateUniqueSlug($request->name);
        $item->status = $request->status;
        $item->price = $request->price;
        $item->thumbnail = $thumbnailImgName;
        $item->save();
        $item->gallery()->create([
            'collection_name' => 'gallery',
            'type' => 'image',
            'gallery' => json_encode($sliderImgURLs),
        ]);
        if(!empty($categories)){
            $item->categories()->attach($categories);
        }

        Session::flash('success', 'Item added successfully!');
        return "success";

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $item = Product::findOrFail($id);

        $data['sliders'] = $item->gallery ? json_decode($item->gallery, true) : [];

        if (isset($data['sliders']['gallery'])) {
            $data['galleries'] = json_decode($data['sliders']['gallery'], true);
        }else{
            $data['galleries'] =[];
        }

        $data['item'] = $item;
        return view('menu-management.items.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'svg');
        if ($request->hasFile('thumbnail')) {
            $thumbnailImgURL = $request->thumbnail;
            $thumbnailImgExt = $thumbnailImgURL ? $thumbnailImgURL->extension() : null;
            $rules['thumbnail'] = function ($attribute, $value, $fail) use ($allowedExtensions, $thumbnailImgExt) {
                if (!in_array($thumbnailImgExt, $allowedExtensions)) {
                    $fail('Only .jpg, .jpeg, .png and .svg file is allowed for thumbnail image.');
                }
            };
        }
        $sliderImgURLs = array_key_exists("image", $request->all()) && count($request->image) > 0 ? $request->image : [];
        $sliderImgExts = [];
        // get all the slider images extension
        if (!empty($sliderImgURLs)) {
            foreach ($sliderImgURLs as $sliderImgURL) {
                $n = strrpos($sliderImgURL, ".");
                $extension = ($n === false) ? "" : substr($sliderImgURL, $n + 1);
                array_push($sliderImgExts, $extension);
            }
        }
        if (array_key_exists("image", $request->all()) && count($request->image) > 0) {
            $rules['image'] = function ($attribute, $value, $fail) use ($allowedExtensions, $sliderImgExts) {
                foreach ($sliderImgExts as $sliderImgExt) {
                    if (!in_array($sliderImgExt, $allowedExtensions)) {
                        $fail('Only .jpg, .jpeg, .png and .svg file is allowed for slider image.');
                        break;
                    }
                }
            };
        }

        $item = Product::find($request->item_id);
        $categories = $request->input('category');
        if ($request->hasFile('thumbnail')) {
            $thumbnailImgURL = $request->thumbnail;
            @unlink(public_path('assets/admin/img/items/thumbnail/' . $item->thumbnail));
            $thumbnailImgName = time() . '.' . $thumbnailImgExt;
            $thumbnailDir = public_path('assets/admin/img/items/thumbnail/');
            @copy($thumbnailImgURL, $thumbnailDir . $thumbnailImgName);
        }

        $pre_title = $item->title ?? '';
        $pre_slug = $item->slug ?? ''; 

        $item->name = $request->name;
        $item->description = $request->description;
        $item->slug = $this->generateUniqueSlugUpdate($request->name, $pre_title, $pre_slug);
        $item->status = $request->status;
        $item->price = $request->price;
        $item->thumbnail = $request->hasFile('thumbnail') ? $thumbnailImgName : $item->thumbnail;
        $item->save();
        $gallery = $item->gallery()->first();
        if ($gallery) {
            $existingGallery = json_decode($gallery->gallery, true);
            $updatedGallery = array_merge($existingGallery, $sliderImgURLs);
            $gallery->update([
                'gallery' => json_encode($updatedGallery),
            ]);
        } else {
            $item->gallery()->create([
                'collection_name' => 'gallery',
                'type' => 'image',
                'gallery' => json_encode($sliderImgURLs),
            ]);
        }
        if (!empty($categories)) {
            $currentCategories = $item->categories->pluck('id')->toArray();
            $categoriesToAttach = array_diff($categories, $currentCategories);
            $categoriesToDetach = array_diff($currentCategories, $categories);
            $item->categories()->attach($categoriesToAttach);
            $item->categories()->detach($categoriesToDetach);
        }
        
        Session::flash('success', 'Product updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }


    public function slider(Request $request)
    {
        $filename = null;
        $request->validate([
            'file' => 'mimes:jpg,jpeg,png|required',
        ]);
        if ($request->hasFile('file')) {
            $filename = Uploader::upload_picture('assets/admin/img/items/slider-images', $request->file('file'));
        }
        return response()->json(['status' => 'success', 'file_id' => $filename]);
    }
    public function sliderRemove(Request $request)
    {
       
        if (file_exists(public_path('assets/admin/img/items/slider-images/' . $request->value))) {
            unlink(public_path('assets/admin/img/items/slider-images/' . $request->value));
            return response()->json(['status' => 200, 'message' => 'success']);
        } else {
            return response()->json(['status' => 404, 'message' => 'error']);
        }
    }
    // public function dbSliderRemove(Request $request)
    // {
    //     $img = UserItemImage::findOrFail($request->id);
    //     @unlink(public_path('assets/front/img/user/items/slider-images/' . $img->image));
    //     $img->delete();
    //     return response()->json(['status' => 200, 'message' => 'success']);
    // }

    private function generateUniqueSlug($title)
    {
        $slug = make_slug($title);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    private function generateUniqueSlugUpdate($title, $item_title, $pre_slug)
    {
        $slug = make_slug($title);
        if ($item_title == $title) {
            return $pre_slug;
        } else {
            $originalSlug = $slug;
            $counter = 1;
    
            // Ensure the slug is unique
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            return $slug;
        }
    }

    public function feature(Request $request)
    {

        $item = Product::findOrFail($request->item_id);
        $item->featured = $request->featured;
        $item->save();

        if ($request->featured == 1) {
            Session::flash('success', 'Item featured successfully!');
        } else {
            Session::flash('success', 'Item unfeatured successfully!');
        }
        return back();
    }

    public function flashRemove(Request $request)
    {
        $item = Product::findOrFail($request->itemId);
        $item->discount_start_date = null;
        $item->discount_end_date = null;
        $item->flash = null;
        $item->discount_amount = null;
        $item->discount_type = null;
        $item->save();
        Session::flash('success', 'Item has been removed from flash sale');
        return "success";
    }

    public function setFlashSale($id, Request $request)
    {
        $rules = [
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'discount_amount' => 'required|numeric|min:0',
        ];
    
        $messages = [
            'start_date.required' => 'The start date field is required',
            'start_time.required' => 'The start time field is required',
            'end_date.required' => 'The end date field is required',
            'end_time.required' => 'The end time field is required',
            'discount_amount.required' => 'The discount field is required',
            'discount_amount.numeric' => 'The discount must be a number',
            'discount_amount.min' => 'The discount cannot be negative',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }
    
        $localTimezone = 'Africa/Addis_Ababa';
        $now = Carbon::now($localTimezone);
        $startDateTime = Carbon::parse("{$request->start_date} {$request->start_time}", $localTimezone)->setTimezone('UTC');
        $endDateTime = Carbon::parse("{$request->end_date} {$request->end_time}", $localTimezone)->setTimezone('UTC');
    
        if ($startDateTime->lt($now->startOfDay())) {
            return Response::json([
                'errors' => ['start_date' => ['The start date must be today or in the future']]
            ], 400);
        }
    
        if ($endDateTime->lte($now->endOfDay())) {
            return Response::json([
                'errors' => ['end_date' => ['The end date must be after today']]
            ], 400);
        }
    
        if ($endDateTime->lessThanOrEqualTo($startDateTime)) {
            return Response::json([
                'errors' => ['end_date' => ['The end date and time must be after the start date and time']]
            ], 400);
        }
    
        $item = Product::findOrFail($id);
        $item->discount_start_date = $startDateTime;
        $item->discount_end_date = $endDateTime;
        $item->discount_amount = $request->discount_amount;
        $item->flash = 1;
        $item->save();
    
        Session::flash('success', 'Flash sale information set successfully');
    
        return "success";
    }

    public function delete(Request $request)
    {
        $item = Product::findOrFail($request->item_id);
        @unlink(public_path('assets/admin/img/items/thumbnail/' . $item->thumbnail));
        $gallery = $item->gallery()->first();
        if ($gallery) {
            $galleries = json_decode($gallery->gallery, true) ?? [];
            foreach ($galleries as $key => $image) {
                @unlink(public_path('assets/admin/img/items/slider-images/' . $image));
            }
            $gallery->delete();
        }
        $item->delete();
        Session::flash('success', 'Item deleted successfully!');
        return back();
    }
    


    public function dbSliderRemove(Request $request)
    {
        $item = Product::findOrFail($request->id);
        $gallery = json_decode($item->gallery->gallery, true);
        $imageToRemove = $request->image;
        if (($key = array_search($imageToRemove, $gallery)) !== false) {
            unset($gallery[$key]);
            $gallery = array_values($gallery);
            $item->gallery->update(['gallery' => json_encode($gallery)]);
            @unlink(public_path('assets/admin/img/items/slider-images/' . $imageToRemove));
            return response()->json(['status' => 200, 'message' => 'Image removed successfully']);
        }
        return response()->json(['status' => 400, 'message' => 'Image not found']);
    }
    
    
    
}
