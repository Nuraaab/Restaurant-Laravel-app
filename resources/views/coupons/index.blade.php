@extends('layout.layout')
@php
    $title = 'Coupons';
    $subTitle = 'Coupons';
@endphp

@section('content')
    <div class="card h-100 p-0 radius-12">
        <div
            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                <form method="GET" action="{{ route('user.coupon.index') }}" class="d-flex align-items-center gap-2">
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
                <form method="GET" action="{{ route('user.coupon.index') }}"
                    class="navbar-search d-flex align-items-center">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search"
                        value="{{ request('search') }}">
                    <button type="submit" class="border-0 bg-transparent">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </button>
                </form>
            </div>
            <a href="{{ route('user.coupon.create') }}"
                class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add Coupon
            </a>
        </div>
        <div class="card-body p-24">
            @if (count($coupons) == 0)
                <h3 class="text-center">NO COUPON FOUND</h3>
            @else
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Discount Type</th>
                                <th scope="col">Discount Amount</th>
                                <th scope="col">Max Use</th>
                                <th scope="col">Use Count</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>{{ $coupon->discount_amount }}</td>
                                    <td>{{ $coupon->max_use }}</td>
                                    <td>{{ $coupon->use_count }}</td>
                                    <td>{{ $coupon->start_date }}</td>
                                    <td>{{ $coupon->end_date }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="{{ route('user.coupon.status') }}"
                                                id="statusForm{{ $coupon->id }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
                                                <select name="status"
                                                    class="form-select form-select-sm @if ($coupon->status) bg-success text-white @else bg-danger text-white @endif"
                                                    onchange="document.getElementById('statusForm{{ $coupon->id }}').submit();">
                                                    <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                            <a href="{{ route('user.coupon.edit', $coupon->id) }}"
                                                class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                            <form action="{{ route('user.coupon.delete') }}" class="deleteform"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
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
                <span>Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }}
                    entries</span>
                {{ $coupons->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
