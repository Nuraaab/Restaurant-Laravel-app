<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $rules = [
            'receipt_footer' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_header' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receipt_stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'currency' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_color' => 'required',
            'secondary_color' => 'required',
            'sender_email' => 'required|email',
            'sender_name' => 'required',
            'map_link' => 'required',
            'tax' => 'required|numeric|min:0',
            'restaurant_name' => 'required',
            'delivery_charge' => 'required|numeric|min:0'
        ];

        $messages = [
            'receipt_footer.image' => 'Receipt footer must be an image file',
            'receipt_footer.mimes' => 'Receipt footer must be a jpeg, png, jpg or gif file',
            'receipt_footer.max' => 'Receipt footer size must not exceed 2MB',
            'receipt_header.image' => 'Receipt header must be an image file',
            'receipt_header.mimes' => 'Receipt header must be a jpeg, png, jpg or gif file',
            'receipt_header.max' => 'Receipt header size must not exceed 2MB',
            'receipt_stamp.image' => 'Receipt stamp must be an image file',
            'receipt_stamp.mimes' => 'Receipt stamp must be a jpeg, png, jpg or gif file',
            'receipt_stamp.max' => 'Receipt stamp size must not exceed 2MB',
            'currency.required' => 'Currency is required',
            'logo.image' => 'Logo must be an image file',
            'logo.mimes' => 'Logo must be a jpeg, png, jpg or gif file',
            'logo.max' => 'Logo size must not exceed 2MB',
            'primary_color.required' => 'Primary color is required',
            'secondary_color.required' => 'Secondary color is required',
            'sender_email.required' => 'Sender email is required',
            'sender_email.email' => 'Sender email must be a valid email address',
            'sender_name.required' => 'Sender name is required',
            'map_link.required' => 'Map link is required',
            'tax.required' => 'Tax is required',
            'tax.numeric' => 'Tax must be a number',
            'tax.min' => 'Tax cannot be negative',
            'restaurant_name.required' => 'Restaurant name is required',
            'delivery_charge.required' => 'Delivery charge is required',
            'delivery_charge.numeric' => 'Delivery charge must be a number',
            'delivery_charge.min' => 'Delivery charge cannot be negative'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && file_exists(public_path('assets/admin/img/settings/' . $settings->logo))) {
                unlink(public_path('assets/admin/img/settings/' . $settings->logo));
            }
            $logo = $request->file('logo');
            $logoName = time() . '_logo.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/admin/img/settings'), $logoName);
            $settings->logo = $logoName;
        }

        // Handle receipt header upload
        if ($request->hasFile('receipt_header')) {
            // Delete old receipt header if exists
            if ($settings->receipt_header && file_exists(public_path('assets/admin/img/settings/' . $settings->receipt_header))) {
                unlink(public_path('assets/admin/img/settings/' . $settings->receipt_header));
            }
            $receiptHeader = $request->file('receipt_header');
            $receiptHeaderName = time() . '_header.' . $receiptHeader->getClientOriginalExtension();
            $receiptHeader->move(public_path('assets/admin/img/settings'), $receiptHeaderName);
            $settings->receipt_header = $receiptHeaderName;
        }

        // Handle receipt footer upload
        if ($request->hasFile('receipt_footer')) {
            // Delete old receipt footer if exists
            if ($settings->receipt_footer && file_exists(public_path('assets/admin/img/settings/' . $settings->receipt_footer))) {
                unlink(public_path('assets/admin/img/settings/' . $settings->receipt_footer));
            }
            $receiptFooter = $request->file('receipt_footer');
            $receiptFooterName = time() . '_footer.' . $receiptFooter->getClientOriginalExtension();
            $receiptFooter->move(public_path('assets/admin/img/settings'), $receiptFooterName);
            $settings->receipt_footer = $receiptFooterName;
        }

        // Handle receipt stamp upload
        if ($request->hasFile('receipt_stamp')) {
            // Delete old receipt stamp if exists
            if ($settings->receipt_stamp && file_exists(public_path('assets/admin/img/settings/' . $settings->receipt_stamp))) {
                unlink(public_path('assets/admin/img/settings/' . $settings->receipt_stamp));
            }
            $receiptStamp = $request->file('receipt_stamp');
            $receiptStampName = time() . '_stamp.' . $receiptStamp->getClientOriginalExtension();
            $receiptStamp->move(public_path('assets/admin/img/settings'), $receiptStampName);
            $settings->receipt_stamp = $receiptStampName;
        }

        $settings->currency = $request->currency;
        $settings->primary_color = $request->primary_color;
        $settings->secondary_color = $request->secondary_color;
        $settings->sender_email = $request->sender_email;
        $settings->sender_name = $request->sender_name;
        $settings->map_link = $request->map_link;
        $settings->tax = $request->tax;
        $settings->restaurant_name = $request->restaurant_name;
        $settings->delivery_charge = $request->delivery_charge;
        $settings->save();

        Session::flash('success', 'Settings updated successfully!');
        return "success";
    }

    public function company()
    {
        return view('settings/company');
    }

    public function currencies()
    {
        return view('settings/currencies');
    }

    public function language()
    {
        return view('settings/language');
    }

    public function notification()
    {
        return view('settings/notification');
    }

    public function notificationAlert()
    {
        return view('settings/notificationAlert');
    }

    public function paymentGateway()
    {
        return view('settings/paymentGateway');
    }

    public function theme()
    {
        return view('settings/theme');
    }

    public function changeReceiptFooter() {}

    public function changeReceiptHeader() {}

    public function updateCurrencies() {}

    public function changeReceiptStamp() {}

    public function changeLogo() {}

    public function changeColors() {}
}
