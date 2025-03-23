@extends('layout.layout')
@php
    $title='Menu Management';
    $subTitle = 'Category';
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
                        <form method="GET" action="{{ route('user.menu.category.index') }}" class="d-flex align-items-center gap-2">
                            <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                                @foreach ([10, 25, 50, 100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('user.menu.category.index') }}" class="navbar-search d-flex align-items-center">
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
                    <a class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#createModal">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add Category
                        </a>

                </div>
                <div class="card-body p-24">
                    @if (count($categories) == 0)
                    <h3 class="text-center">NO CATEGORY FOUND</h3>
                    @else
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                               
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    
                                    <td>{{$category->name}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/admin/img/categories/'. $category->image) }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                                            
                                        </div>
                                    </td>
                                    <td class="text-center">
                                    @if ($category->status == 1)
                                        <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
                                    @else
                                        <span class="bg-danger-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Deactive</span>
                                    @endif
                                     </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-10 justify-content-center">
                                        
                                            <a href="{{route('user.menu.category.edit', $category->id)}}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            </a>
                                            <form action="{{route('user.menu.category.delete')}}" class="deleteform" method="post">
                                                @csrf
                                                <input type="hidden" name="category_id"
                                                                value="{{ $category->id }}">
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
                        <span>Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries</span>
                        {{ $categories->links('pagination::bootstrap-4') }} <!-- Use Laravel pagination links -->
                    </div>
                </div>
            </div>

              <!-- Create Service Category Modal -->
       
              <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Menu Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="ajaxForm" class="modal-form" enctype="multipart/form-data"
                                action="{{ route('user.menu.category.store')}}" method="POST">
                                @csrf
                                <p id="errslug" class="mb-0 text-danger em"></p>
                                <div class="form-group">
                                    <div class="col-12 mb-2">
                                        <label for="image"><strong>{{ __('Category Image') }} **</strong></label>
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
