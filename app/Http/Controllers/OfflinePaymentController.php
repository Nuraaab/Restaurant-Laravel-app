<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\OfflinePayment;
use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use Session;
use Validator;

class OfflinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $offlinePayments = OfflinePayment::with('logo')->get();
        // dd($chapa->logo,$chapa);

        return view('payment-geteway.offlinePaymentGateway', compact('offlinePayments'));
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
        //

        $rules = [
            'name' => 'required|max:255',
            'instruction' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }



        $offlinePayment = new OfflinePayment();
        $offlinePayment->instruction = $request->instruction;
        $offlinePayment->description = $request->description;
        $offlinePayment->name = $request->name;

        $offlinePayment->status = $request->status == '1' ? true : false;


        $offlinePayment->save();



        // Handle file upload (logo)
        if ($request->hasFile('image')) {
            $logoImgURL = $request->file('image');
            $logoImgExt = $logoImgURL->extension();

            // Set a name for the logo image and store it to local storage
            $logoImgName = time() . '.' . $logoImgExt;
            $logoDir = public_path('assets/admin/payment/offline/logo/');
            @mkdir($logoDir, 0775, true);
            @copy($logoImgURL, $logoDir . $logoImgName);

            // Save to media table
            Media::updateOrCreate(
                ['model_type' => OfflinePayment::class, 'model_id' => $offlinePayment->id, 'collection_name' => 'logo'],
                ['file_path' => $logoImgName, 'type' => 'image', 'mime_type' => $logoImgURL->getMimeType()]
            );
        }


        Session::flash('success', 'New Ofline Payment Method added successfully!');
        return "success";
    }

    /**
     * Display the specified resource.
     */
    public function show(OfflinePayment $offlinePayment)
    {
        //
        dd($offlinePayment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfflinePayment $offlinePayment)
    {
        //

        dd($offlinePayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfflinePayment $offlinePayment)
    {
        //
        dd($request->all());
    }


    public function delete(Request $request)
    {
        $offlinePayment = OfflinePayment::findOrFail($request->id);
        // dd($offlinePayment->logo);
        @unlink(public_path('assets/admin/payment/offline/logo/' . $offlinePayment->logo->file_path));
        $offlinePayment->delete();

        Session::flash('success', 'Ofline Payment Method remove successfully!');
        return back();
    }
    public function changestatus(Request $request, $id)
    {

        $offlinePayment = OfflinePayment::findOrFail($request->id);
        $status = false;
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $offlinePayment->status = $status;
        $offlinePayment->save();
        Session::flash('success', 'Offline Payment Method ' . $offlinePayment->name . ' status turned ' . ($status ? "on" : "off") . ' successfully!');
        return back();
    }
}
