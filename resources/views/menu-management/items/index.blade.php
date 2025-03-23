@extends('layout.layout')
@php
    $title='Menu Management';
    $subTitle = 'Items';
    $script ='<script>
                        $(".remove-item-btn").on("click", function() {
                            $(this).closest("tr").addClass("d-none")
                        });
            </script>';
@endphp

@section('content')

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                        <form method="GET" action="{{ route('user.menu.item.index') }}" class="d-flex align-items-center gap-2">
                            <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                                @foreach ([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('user.menu.item.index') }}" class="navbar-search d-flex align-items-center">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" value="{{ request('search') }}">
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
                    <a href="{{ route('user.menu.item.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add Item
                        </a>

                </div>
                <div class="card-body p-24">
                    @if (count($items) == 0)
                    <h3 class="text-center">NO ITEM FOUND</h3>
                    @else
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                               
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col" class="text-center">Featured</th>
                                    <th scope="col" class="text-center">Flash</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->price}}</td>
                                    
                                     <!-- Featured Column -->
                                     <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="{{ route('user.menu.item.feature') }}" id="featureForm{{ $item->id }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <select name="featured"
                                                        class="form-select form-select-sm @if ($item->featured) bg-success text-white @else bg-danger text-white @endif"
                                                        onchange="document.getElementById('featureForm{{ $item->id }}').submit();">
                                                    <option value="1" {{ $item->featured == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ $item->featured == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                    
                                    @php
                                        $isFlash = App\Helpers\CheckFlashItem::isFlashItem($item->id);
                                    @endphp

                                    <!-- Flash Column -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <form action="{{ route('user.menu.item.flash.remove') }}" id="flashForm{{ $item->id }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <select name="special_offer" data-item-id="{{ $item->id }}"
                                                        class="form-select form-select-sm manageFlash @if ($isFlash) bg-success text-white @else bg-danger text-white @endif">
                                                    <option value="1" {{ $isFlash == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ $isFlash == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </form>
                                    
                                            @if ($isFlash)
                                                <a class="btn btn-sm btn-primary mt-1 ms-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#flashmodal{{ $item->id }}">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    
                                        <!-- Flash Sale Modal -->
                                        <div class="modal fade" id="flashmodal{{ $item->id }}" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Flash Sale Setting</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="modal-form" id="modalform{{ $item->id }}" enctype="multipart/form-data"
                                                              action="{{ route('user.menu.item.setFlashSale', $item->id) }}" method="POST">
                                                            @csrf
                                    
                                                            <div class="form-group text-start">
                                                                <label for="start_date">Start Date **</label>
                                                                <input type="text" value="{{ $item->discount_start_date }}" 
                                                                       name="start_date" 
                                                                       class="form-control datapicker" 
                                                                       autocomplete="off" 
                                                                       placeholder="Select start date">
                                                                <p id="errstart_date" class="mb-0 text-danger em"></p>
                                                            </div>
                                    
                                                            <div class="form-group text-start">
                                                                <label for="start_date">Start Time **</label>
                                                                <input type="text" value="{{ old('start_time', \Carbon\Carbon::parse($item->discount_start_date)->format('H:i')) }}" 
                                                                       name="start_time" 
                                                                       class="form-control timepicker" 
                                                                       autocomplete="off" 
                                                                       placeholder="Select start time">
                                                                <p id="errstart_time" class="mb-0 text-danger em"></p>
                                                            </div>
                                    
                                                            <div class="form-group text-start">
                                                                <label for="end_date">End Date **</label>
                                                                <input type="text" name="end_date" value="{{ $item->discount_end_date }}"
                                                                       class="form-control datapicker" autocomplete="off" placeholder="Select end date">
                                                                <p id="errend_date" class="mb-0 text-danger em"></p>
                                                            </div>
                                    
                                                            <div class="form-group text-start">
                                                                <label for="end_time">End Time **</label>
                                                                <input type="text" value="{{ old('end_time', \Carbon\Carbon::parse($item->discount_end_date)->format('H:i')) }}" 
                                                                       name="end_time" 
                                                                       class="form-control timepicker" 
                                                                       autocomplete="off" 
                                                                       placeholder="Select end time">
                                                                <p id="errend_time" class="mb-0 text-danger em"></p>
                                                            </div>
                                    
                                                            <div class="form-group text-start">
                                                                <label for="discount_amount">Discount **</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="discount_amount" value="{{ $item->discount_amount }}"
                                                                           class="form-control" aria-describedby="basic-addon1" autocomplete="off" placeholder="">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                                    </div>
                                                                </div>
                                                                <p id="errdiscount_amount" class="mb-0 text-danger em"></p>
                                                            </div>
                                    
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" data-id="{{ $item->id }}" class="submitBtn btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                        
                                            <a href="{{route('user.menu.item.edit', $item->id)}}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                            <form action="{{route('user.menu.item.delete')}}" class="deleteform" method="post">
                                                @csrf
                                                <input type="hidden" name="item_id"
                                                                value="{{ $item->id }}">
                                                <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle deletebtn">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
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
                        <span>Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} entries</span>
                        {{ $items->links('pagination::bootstrap-4') }} <!-- Use Laravel pagination links -->
                    </div>
                </div>
            </div>
@endsection
