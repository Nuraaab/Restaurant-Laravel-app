@extends('layout.layout')
@php
    $title = 'Offline Payment';
    $subTitle = 'PaymentGeteway - ofline';
@endphp

@section('content')

    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <!-- <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                                            <form method="GET" action="{{ route('user.menu.category.index') }}" class="d-flex align-items-center gap-2">
                                                <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px"
                                                    onchange="this.form.submit()">
                                                    @foreach ([10, 25, 50, 100] as $size)
                                                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                                            {{ $size }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form> -->

                <!-- Search Form -->
                <!-- <form method="GET" action="{{ route('user.menu.category.index') }}"
                                                class="navbar-search d-flex align-items-center">
                                                <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                                                    value="{{ request('search') }}">
                                                <button type="submit" class="border-0 bg-transparent">
                                                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                                                </button>
                                            </form> -->

                {{-- <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                    <option>Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select> --}}
            </div>
            <a class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#createModal">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add Payment
            </a>

        </div>
        <div class="card-body p-24">
            @if (count($offlinePayments) == 0)
                <h3 class="text-center">NO OFLINE PAYMENT FOUND</h3>
            @else
                <div class="row gy-4">
                    @foreach ($offlinePayments as $offlinePayment)
                        <div class="col-xxl-6">

                            <div class="card radius-12 shadow-none border overflow-hidden">

                                <div
                                    class="card-header bg-neutral-100 border-bottom py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                                    <div class="d-flex align-items-center gap-10">
                                        <span
                                            class="w-36-px h-36-px bg-base rounded-circle d-flex justify-content-center align-items-center">
                                            @if($offlinePayment->logo)
                                                <img src="{{ asset('assets/admin/payment/offline/logo/' . $offlinePayment->logo->file_path) }}"
                                                    alt="Logo" class="">
                                            @else
                                                <img src="{{ asset('storage/' . "") }}" alt="" class="">
                                            @endif
                                        </span>
                                        <span class="text-lg fw-semibold text-primary-light">{{$offlinePayment->name}}</span>
                                    </div>
                                    <div class="form-switch switch-primary d-flex align-items-center justify-content-center"><input
                                            class="form-check-input" type="checkbox" role="switch" {{ $offlinePayment->status ? 'checked' : '' }} /> </div>
                                </div>

                                <div class="card-body p-24">
                                    <div class="row gy-3">
                                        <div class="col-sm-12">
                                            <label for="instruction"
                                                class="form-label fw-semibold text-primary-light text-md mb-8">Instruction </label>
                                            <div>
                                                {{ $offlinePayment->description }}
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="instruction"
                                                class="form-label fw-semibold text-primary-light text-md mb-8">Instruction</label>

                                            <div>
                                                {{ $offlinePayment->instruction }}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="logo" class="form-label fw-semibold text-primary-light text-md mb-8"><span
                                                    class="visibility-hidden">Save</span></label>
                                            <button type="submit"
                                                class="btn btn-primary border border-primary-600 text-md px-24 py-8 radius-8 w-100 text-center">
                                                Save Change
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Ofline Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form" enctype="multipart/form-data"
                        action="{{ route('paymentgateway.offline.store') }}" method="POST">
                        @csrf
                        <p id="errslug" class="mb-0 text-danger em"></p>
                        <div class="form-group">
                            <div class="col-12 mb-2">
                                <label for="image"><strong>{{ __('Payment Method Logo') }} **</strong></label>
                            </div>
                            <div class="col-md-12 showImage mb-3">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..." class="img-thumbnail">
                            </div>
                            <input type="file" name="image" id="image" class="form-control">
                            <p id="errimage" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group">
                            <label for="">Name **</label>
                            <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
                            <p id="errname" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Description **</label>
                            <input type="text" class="form-control" name="description" value=""
                                placeholder="Enter description">
                            <p id="errdescription" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Instruction **</label>
                            <textarea class="form-control" name="instruction" rows="4"
                                placeholder="Enter instruction"></textarea>
                            <p id="errinstruction" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Status **</label>
                            <select class="form-control ltr" name="status">
                                <option value="" selected disabled>Select a status</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                            <p id="errstatus" class="mb-0 text-danger em"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection