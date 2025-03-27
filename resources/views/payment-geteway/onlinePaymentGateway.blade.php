@extends('layout.layout')
@php
    $title = 'Online Payment';
    $subTitle = 'PaymentGeteway - Online';
@endphp

@section('content')

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <div class="row gy-4">
                <div class="col-xxl-6">

                    <div class="card radius-12 shadow-none border overflow-hidden">

                        <div
                            class="card-header bg-neutral-100 border-bottom py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div class="d-flex align-items-center gap-10">
                                <span
                                    class="w-36-px h-36-px bg-base rounded-circle d-flex justify-content-center align-items-center">
                                    @if($chapa->logo)
                                        <img src="{{ asset('assets/admin/payment/online/logo/' . $chapa->logo->file_path) }}"
                                            alt="Logo" class="">
                                    @else
                                        <img src="{{ asset('storage/' . "") }}" alt="" class="">
                                    @endif
                                </span>
                                <span class="text-lg fw-semibold text-primary-light">{{$chapa->name}}</span>
                            </div>
                            <form action="{{ route('paymentgateway.online.changestatus', $chapa->id) }}" method="POST">
                                @csrf
                                <div class="form-switch switch-primary d-flex align-items-center justify-content-center">
                                    <input name="status" class="form-check-input" type="checkbox" role="switch" {{ $chapa->status ? 'checked' : '' }} onchange="submit()" />
                                </div>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('paymentgateway.online.update', $chapa->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body p-24">
                                <div class="row gy-3">
                                    <div class="col-sm-6">
                                        <label for="secretKey"
                                            class="form-label fw-semibold text-primary-light text-md mb-8">Secret Key <span
                                                class="text-danger-600">*</span></label>
                                        <input type="text" class="form-control radius-8" id="secretKey" name="secret_key"
                                            placeholder="Secret Key" value="{{ $chapa->information['secret_key'] }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="publicKey"
                                            class="form-label fw-semibold text-primary-light text-md mb-8">Publics Key<span
                                                class="text-danger-600">*</span></label>
                                        <input type="text" class="form-control radius-8" id="publicKey" name="public_key"
                                            placeholder="Publics Key" value="{{$chapa->information['public_key']}}">
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="logo"
                                            class="form-label fw-semibold text-primary-light text-md mb-8">Logo
                                            <span class="text-danger-600">*</span></label>
                                        <input type="file" class="form-control radius-8" id="logo" name="logo">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="logo"
                                            class="form-label fw-semibold text-primary-light text-md mb-8"><span
                                                class="visibility-hidden">Save</span></label>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-24 py-8 radius-8 w-100 text-center">
                                            Save Change
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection