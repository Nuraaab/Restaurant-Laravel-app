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
        $item->save();
        $item->thumbnail()->create([
            'collection_name' => 'thumbnail',
            'type' => 'image',
            'file_path' => $thumbnailImgName,
            'mime_type' => $thumbnailImgURL->getMimeType(),
        ]);

        $item->sliders()->create([
            'collection_name' => 'slider',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
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
        $startDate = $request->start_date . ' ' . $request->start_time;
        $startDateTime = Carbon::parse($startDate)->timezone($localTimezone)->setTimezone('UTC');
        $endDate = $request->end_date . ' ' . $request->end_time;
        $endDateTime = Carbon::parse($endDate)->timezone($localTimezone)->setTimezone('UTC');
        $item = Product::findOrFail($id);
        $item->discount_start_date = $startDateTime;
        $item->discount_end_date = $endDateTime;
        $item->discount_amount = $request->discount_amount;
        $item->flash = 1;
        $item->save();
        Session::flash('success', 'Flash sale information set successfully');
        
        return "success";
    }
    
}
