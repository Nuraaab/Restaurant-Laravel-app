@extends('layout.layout')
@php
    $title = 'Edit Payment Method';
    $subTitle = 'Edit Payment Method';
    $script = '<script>
                                    $(".remove-item-btn").on("click", function() {
                                        $(this).closest("tr").addClass("d-none")
                                    });
                        </script>';
@endphp

@section('content')
    <style>
        .modal-footer {
            display: flex;
            justify-content: center !important;
            align-items: center;
            /* Center vertically if necessary */
        }
    </style>

    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <h5>Edit Payment Method</h5>
            </div>
            <a href="{{route('paymentgateway.offline.index')}}"
                class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-arrow-back" class="icon text-xl line-height-1"></iconify-icon>
                Back
            </a>

        </div>
        <div class="card-body p-24">
            <form id="ajaxForm" class="modal-form" enctype="multipart/form-data"
                action="{{ route('paymentgateway.offline.update', )}}" method="POST">
                @csrf
                <p id="errslug" class="mb-0 text-danger em"></p>

                <div class="form-group">
                    <div class="col-12 mb-2">
                        <label for="image"><strong>{{ __('Payment Image') }} **</strong></label>
                    </div>
                    <div class="col-md-12 showImage mb-3">
                        <img src="{{ $data->logo ? asset('assets/admin/payment/offline/logo/' . $data->logo->file_path) : asset('assets/admin/img/noimage.jpg') }}"
                            alt="..." class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <input type="file" name="image" id="image" class="form-control">
                    <p id="errimage" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                    <label for="">Name **</label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}" placeholder="Enter name">
                    <p id="errname" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                    <label for="">Description **</label>
                    <input type="text" class="form-control" name="description" value="{{ $data->description }}" placeholder="Enter description">
                    <p id="errdescription" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                    <label for="">Instruction **</label>
                    <textarea class="form-control" name="instruction" rows="4"  placeholder="Enter instruction">{{ $data->instruction }}</textarea>
                    <p id="errinstruction" class="mb-0 text-danger em"></p>
                </div>
                
                <input type="hidden" name="payment_id" value="{{ $data->id }}">

            </form>
        </div>

        <div class="modal-footer mb-4 d-flex jusstify-content-center align-items-center">
            <button id="submitBtn" type="button" class="btn btn-success">Update</button>
        </div>
    </div>






@endsection