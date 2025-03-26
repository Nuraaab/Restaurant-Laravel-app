<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);
        $query = Coupon::query();

        if (!empty($search)) {
            $query->where('code', 'like', "%$search%");
        }

        $data['coupons'] = $query->orderBy('id', 'DESC')->paginate($perPage);
        $data['search'] = $search;
        $data['perPage'] = $perPage;

        return view('menu-management.coupons.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu-management.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'max_use' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:0,1'
        ];

        $messages = [
            'code.required' => 'The coupon code is required',
            'code.unique' => 'This coupon code already exists',
            'discount_type.required' => 'The discount type is required',
            'discount_type.in' => 'Invalid discount type',
            'discount_amount.required' => 'The discount amount is required',
            'discount_amount.numeric' => 'The discount amount must be a number',
            'discount_amount.min' => 'The discount amount cannot be negative',
            'max_use.required' => 'The maximum usage limit is required',
            'max_use.numeric' => 'The maximum usage limit must be a number',
            'max_use.min' => 'The maximum usage limit must be at least 1',
            'start_date.required' => 'The start date is required',
            'start_date.date' => 'Invalid start date format',
            'end_date.required' => 'The end date is required',
            'end_date.date' => 'Invalid end date format',
            'end_date.after' => 'The end date must be after the start date',
            'min_order_amount.numeric' => 'The minimum order amount must be a number',
            'min_order_amount.min' => 'The minimum order amount cannot be negative',
            'status.required' => 'The status is required',
            'status.in' => 'Invalid status value'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->max_use = $request->max_use;
        $coupon->use_count = 0;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->min_order_amount = $request->min_order_amount;
        $coupon->status = $request->status;
        $coupon->save();

        Session::flash('success', 'Coupon added successfully!');
        return "success";
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('menu-management.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rules = [
            'coupon_id' => 'required|exists:coupons,id',
            'code' => 'required|unique:coupons,code,' . $request->coupon_id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'max_use' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:0,1'
        ];

        $messages = [
            'coupon_id.required' => 'Coupon ID is required',
            'coupon_id.exists' => 'Coupon not found',
            'code.required' => 'The coupon code is required',
            'code.unique' => 'This coupon code already exists',
            'discount_type.required' => 'The discount type is required',
            'discount_type.in' => 'Invalid discount type',
            'discount_amount.required' => 'The discount amount is required',
            'discount_amount.numeric' => 'The discount amount must be a number',
            'discount_amount.min' => 'The discount amount cannot be negative',
            'max_use.required' => 'The maximum usage limit is required',
            'max_use.numeric' => 'The maximum usage limit must be a number',
            'max_use.min' => 'The maximum usage limit must be at least 1',
            'start_date.required' => 'The start date is required',
            'start_date.date' => 'Invalid start date format',
            'end_date.required' => 'The end date is required',
            'end_date.date' => 'Invalid end date format',
            'end_date.after' => 'The end date must be after the start date',
            'min_order_amount.numeric' => 'The minimum order amount must be a number',
            'min_order_amount.min' => 'The minimum order amount cannot be negative',
            'status.required' => 'The status is required',
            'status.in' => 'Invalid status value'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $coupon = Coupon::findOrFail($request->coupon_id);
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->min_order_amount = $request->min_order_amount;
        $coupon->status = $request->status;
        $coupon->save();

        Session::flash('success', 'Coupon updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $coupon = Coupon::findOrFail($request->coupon_id);
        $coupon->delete();
        Session::flash('success', 'Coupon deleted successfully!');
        return back();
    }

    /**
     * Update coupon status
     */
    public function status(Request $request)
    {
        $coupon = Coupon::findOrFail($request->coupon_id);
        $coupon->status = $request->status;
        $coupon->save();

        if ($request->status == 1) {
            Session::flash('success', 'Coupon activated successfully!');
        } else {
            Session::flash('success', 'Coupon deactivated successfully!');
        }
        return back();
    }
}
