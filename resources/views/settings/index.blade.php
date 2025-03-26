@extends('layout.layout')
@section('title', 'Settings')
@section('subtitle', 'Manage System Settings')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">System Settings</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form id="settingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="restaurant_name">Restaurant Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name"
                                value="{{ $settings->restaurant_name ?? '' }}" required>
                            <span class="text-danger error-text restaurant_name_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            @if (isset($settings->logo))
                                <img src="{{ asset('assets/admin/img/settings/' . $settings->logo) }}" alt="Logo"
                                    class="mt-2" style="max-height: 100px;">
                            @endif
                            <span class="text-danger error-text logo_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="receipt_header">Receipt Header <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="receipt_header" name="receipt_header"
                                accept="image/*">
                            @if (isset($settings->receipt_header))
                                <img src="{{ asset('assets/admin/img/settings/' . $settings->receipt_header) }}"
                                    alt="Receipt Header" class="mt-2" style="max-height: 100px;">
                            @endif
                            <span class="text-danger error-text receipt_header_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="receipt_footer">Receipt Footer <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="receipt_footer" name="receipt_footer"
                                accept="image/*">
                            @if (isset($settings->receipt_footer))
                                <img src="{{ asset('assets/admin/img/settings/' . $settings->receipt_footer) }}"
                                    alt="Receipt Footer" class="mt-2" style="max-height: 100px;">
                            @endif
                            <span class="text-danger error-text receipt_footer_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="receipt_stamp">Receipt Stamp <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="receipt_stamp" name="receipt_stamp"
                                accept="image/*">
                            @if (isset($settings->receipt_stamp))
                                <img src="{{ asset('assets/admin/img/settings/' . $settings->receipt_stamp) }}"
                                    alt="Receipt Stamp" class="mt-2" style="max-height: 100px;">
                            @endif
                            <span class="text-danger error-text receipt_stamp_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="currency">Currency <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="currency" name="currency"
                                value="{{ $settings->currency ?? '' }}" required>
                            <span class="text-danger error-text currency_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="tax">Tax (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="tax" name="tax"
                                value="{{ $settings->tax ?? '' }}" required min="0" step="0.01">
                            <span class="text-danger error-text tax_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="delivery_charge">Delivery Charge <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="delivery_charge" name="delivery_charge"
                                value="{{ $settings->delivery_charge ?? '' }}" required min="0" step="0.01">
                            <span class="text-danger error-text delivery_charge_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="primary_color">Primary Color <span class="text-danger">*</span></label>
                            <input type="color" class="form-control" id="primary_color" name="primary_color"
                                value="{{ $settings->primary_color ?? '#000000' }}" required>
                            <span class="text-danger error-text primary_color_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="secondary_color">Secondary Color <span class="text-danger">*</span></label>
                            <input type="color" class="form-control" id="secondary_color" name="secondary_color"
                                value="{{ $settings->secondary_color ?? '#ffffff' }}" required>
                            <span class="text-danger error-text secondary_color_error"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sender_name">Sender Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sender_name" name="sender_name"
                                value="{{ $settings->sender_name ?? '' }}" required>
                            <span class="text-danger error-text sender_name_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="sender_email">Sender Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="sender_email" name="sender_email"
                                value="{{ $settings->sender_email ?? '' }}" required>
                            <span class="text-danger error-text sender_email_error"></span>
                        </div>

                        <div class="form-group">
                            <label for="map_link">Map Link <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="map_link" name="map_link"
                                value="{{ $settings->map_link ?? '' }}" required>
                            <span class="text-danger error-text map_link_error"></span>
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer mb-4 d-flex justify-content-center align-items-center">
                <button form="settingsForm" type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
@endsection
