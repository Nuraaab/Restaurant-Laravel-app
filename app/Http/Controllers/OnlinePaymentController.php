<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\OnlinePayment;
use Illuminate\Http\Request;
use Session;

class OnlinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $chapa = OnlinePayment::with('logo')->findOrFail(1);
        // dd($chapa->logo,$chapa);

        return view('payment-geteway.online.index', compact('chapa'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnlinePayment $onlinePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $onlinePaymentId)
    {
        // Find the payment gateway record
        $onlinePayment = OnlinePayment::findOrFail($onlinePaymentId);

        // Validate the input data
        $validatedData = $request->validate([
            'secret_key' => 'required|string',
            'public_key' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // File validation
        ]);

        // Update the JSON field
        $onlinePayment->information = [
            'secret_key' => $validatedData['secret_key'],
            'public_key' => $validatedData['public_key']
        ];

        // Handle file upload (logo)
        if ($request->hasFile('logo')) {
            $logoImgURL = $request->file('logo');
            $logoImgExt = $logoImgURL->extension();

            // Set a name for the logo image and store it to local storage
            $logoImgName = time() . '.' . $logoImgExt;
            $logoDir = public_path('assets/admin/payment/online/logo/');
            @mkdir($logoDir, 0775, true);
            @copy($logoImgURL, $logoDir . $logoImgName);

            // Save to media table
            Media::updateOrCreate(
                ['model_type' => OnlinePayment::class, 'model_id' => $onlinePayment->id, 'collection_name' => 'logo'],
                ['file_path' => $logoImgName, 'type' => 'image', 'mime_type' => $logoImgURL->getMimeType()]
            );
        }

        // Save changes
        $onlinePayment->save();


        return redirect()->back()->with('success', 'Payment gateway updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnlinePayment $onlinePayment)
    {
        //
    }

    public function changestatus(Request $request, $id)
    {

        $onlinePayment = OnlinePayment::findOrFail($request->id);
        $status = false;
        if ($request->status) {
            $status = true;
        } else {
            $status = false;
        }
        $onlinePayment->status = $status;
        $onlinePayment->save();
        Session::flash('success', 'Online Payment Method ' . $onlinePayment->name . ' status turned ' . ($status ? "on" : "off") . ' successfully!');
        return back();
    }
}
