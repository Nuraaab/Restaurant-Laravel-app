@extends('layout.layout')
@php
    $title = 'Order Details';
    $subTitle = 'Order Details';
@endphp

@section('content')
    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <h4>📝 Order Details</h4>
            </div>
            <a href="{{ route('user.menu.order.index') }}" class="btn btn-secondary text-sm btn-sm px-12 py-12 radius-8">
                Back to Orders
            </a>
        </div>

        <div class="card-body p-24">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Order #{{ $order->id }}</h5>
                    <p class="mb-1">Date: {{ $order->created_at->format('d M Y h:i a') }}</p>
                    <div class="mb-2">
                        <span class="fw-bold">Order Status:</span>
                        @if ($order->order_status == 'delivered')
                            <span
                                class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Delivered</span>
                        @elseif ($order->order_status == 'shipped')
                            <span
                                class="bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Shipped</span>
                        @else
                            <span
                                class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                        @endif
                    </div>
                    <div>
                        <span class="fw-bold">Payment Status:</span>
                        @if ($order->payment_status == 'completed')
                            <span
                                class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Paid</span>
                        @else
                            <span
                                class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <span class="fw-bold">Payment Method:</span> {{ $order->payment_method }}
                    </div>
                </div>
                <div class="col-md-6 text-start">
                    <div class="card p-3 bg-base">
                        <h6 class="mb-3">Customer Information</h6>
                        <p class="mb-1">Name: {{ $order->first_name }} {{ $order->last_name }}</p>
                        <p class="mb-1">Email: {{ $order->email }}</p>
                        <p class="mb-1">Phone: {{ $order->phone_number }}</p>
                        <p class="mb-1">Address: {{ $order->address }}</p>
                        <p class="mb-1">City: {{ $order->city }}</p>
                        <p class="mb-0">Country: {{ $order->country }}</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}{{ $order->currency_code }}</td>
                                <td>{{ number_format($item->quantity * $item->unit_price, 2) }}{{ $order->currency_code }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4 d-flex justify-content-end">
                <div class="col-md-6">
                    <div class="card p-3 bg-base">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Sub Total</td>
                                <td class="text-end">{{ number_format($order->sub_total, 2) }}{{ $order->currency_code }}
                                </td>
                            </tr>
                            @if ($order->discount_amount > 0)
                                <tr>
                                    <td class="fw-bold">Discount</td>
                                    <td class="text-end">
                                        {{ number_format($order->discount_amount, 2) }}{{ $order->currency_code }}</td>
                                </tr>
                            @endif
                            @if ($order->coupon_discount > 0)
                                <tr>
                                    <td class="fw-bold">Coupon Discount</td>
                                    <td class="text-end">
                                        {{ number_format($order->coupon_discount, 2) }}{{ $order->currency_code }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="fw-bold">Grand Total</td>
                                <td class="text-end fw-bold">
                                    {{ number_format($order->total, 2) }}{{ $order->currency_code }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
