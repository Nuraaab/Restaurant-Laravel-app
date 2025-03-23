@extends('layout.layout')
@php
    $title = 'Orders';
    $subTitle = 'Orders';
    $script = '<script>
        $(".remove-item-btn").on("click", function() {
            $(this).closest("tr").addClass("d-none")
        });
    </script>';
@endphp

@section('content')

    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                <form method="GET" action="{{ route('user.menu.order.index') }}" class="d-flex align-items-center gap-2">
                    <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px"
                        onchange="this.form.submit()">
                        @foreach ([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Search Form -->
                <form method="GET" action="{{ route('user.menu.order.index') }}"
                    class="navbar-search d-flex align-items-center">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                        value="{{ request('search') }}">
                    <button type="submit" class="border-0 bg-transparent">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </button>
                </form>

                {{-- <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
                            <option>Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select> --}}
            </div>
            {{-- <a class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#createModal">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add Category
            </a> --}}

        </div>
        <div class="card-body p-24">
            @if (count($orders) == 0)
                <h3 class="text-center">NO ORDER FOUND</h3>
            @else
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>

                            <th scope="col">Order ID</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Total</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Discount Amount</th>
                            <th scope="col">Coupon Discount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Payment Type</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Order Status</th>
                            <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                    <td>{{ number_format($order->total, 2) }}{{ $order->currency_code }} </td>
                                    <td>{{ number_format($order->sub_total, 2) }}{{ $order->currency_code }} </td>
                                    <td>{{ number_format($order->discount_amount, 2) }}{{ $order->currency_code }} </td>
                                    <td>{{ number_format($order->coupon_discount, 2) }}{{ $order->currency_code }} </td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->payment_type }}</td>
                                    <td>
                                        @if ($order->payment_status == 'completed')
                                            <span
                                                class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Completed</span>
                                        @elseif ($order->payment_status == 'pending')
                                            <span
                                                class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                                        @else
                                            <span
                                                class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="{{ route('user.menu.order.status') }}"
                                                id="statusForm{{ $order->id }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <select name="order_status"
                                                    class="form-select form-select-sm @if ($order->order_status == 'delivered') bg-success text-white @elseif ($order->order_status == 'shipped') bg-info text-white @else bg-warning text-white @endif"
                                                    onchange="document.getElementById('statusForm{{ $order->id }}').submit();">
                                                    <option value="pending"
                                                        {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="shipped"
                                                        {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped
                                                    </option>
                                                    <option value="delivered"
                                                        {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                                        Delivered</option>
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('user.menu.order.show', $order->id) }}"
                                                class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="carbon:view" class="menu-icon"></iconify-icon>
                                            </a>
                                            <form action="{{ route('user.menu.order.delete') }}" class="deleteform"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <button type="submit"
                                                    class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle deletebtn">
                                                    <iconify-icon icon="fluent:delete-24-regular"
                                                        class="menu-icon"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                <span>Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                    {{ $orders->total() }} entries</span>
                {{ $orders->links('pagination::bootstrap-4') }} <!-- Use Laravel pagination links -->
            </div>
        </div>
    </div>
@endsection
