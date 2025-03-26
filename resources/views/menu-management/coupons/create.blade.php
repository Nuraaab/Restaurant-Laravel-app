@extends('layout.layout')
@php
    $title = 'Add Coupon';
    $subTitle = 'Add Coupon';
@endphp

@section('content')
    <style>
        .modal-footer {
            display: flex;
            justify-content: center !important;
            align-items: center;
        }
    </style>

    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <h5>Add Coupon</h5>
            </div>
            <a href="{{ route('user.coupon.index') }}"
                class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-arrow-back" class="icon text-xl line-height-1"></iconify-icon>
                Back
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="alert alert-danger pb-1 position-relative fade" id="postErrors" role="alert"
                    style="display: none;">
                    <button type="button" class="btn-close position-absolute" style="top: 5px; right: 10px;"
                        data-bs-dismiss="alert" aria-label="Close"></button>
                    <ul class="mb-0 mt-2"></ul>
                </div>

                <form id="couponForm" class="" action="{{ route('user.coupon.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Coupon Code *</label>
                                <input type="text" class="form-control" name="code" placeholder="Enter coupon code">
                                <p id="err_code" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Discount Type *</label>
                                <select class="form-control" name="discount_type">
                                    <option value="" selected disabled>Select discount type</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                                <p id="err_discount_type" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Discount Amount *</label>
                                <input type="number" class="form-control" name="discount_amount"
                                    placeholder="Enter discount amount">
                                <p id="err_discount_amount" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Max Use *</label>
                                <input type="number" class="form-control" name="max_use"
                                    placeholder="Enter maximum usage limit">
                                <p id="err_max_use" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Start Date *</label>
                                <input type="date" class="form-control" name="start_date">
                                <p id="err_start_date" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">End Date *</label>
                                <input type="date" class="form-control" name="end_date">
                                <p id="err_end_date" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Minimum Order Amount</label>
                                <input type="number" class="form-control" name="min_order_amount"
                                    placeholder="Enter minimum order amount">
                                <p id="err_min_order_amount" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Status *</label>
                                <select class="form-control" name="status">
                                    <option value="" selected disabled>Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <p id="err_status" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-footer mb-4 d-flex justify-content-center align-items-center">
        <button form="couponForm" type="submit" class="btn btn-success">Submit</button>
    </div>
@endsection
