@extends('layout.layout')
@php
    $title='Edit Category';
    $subTitle = 'Edit Category';
    $script ='<script>
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
    align-items: center;  /* Center vertically if necessary */
}

</style>

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <h5>Edit Category</h5>
                    </div>
                    <a href="{{route('user.menu.category.index')}}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-arrow-back" class="icon text-xl line-height-1"></iconify-icon>
                         Back
                        </a>

                </div>
                <div class="card-body p-24">
                    <form id="ajaxForm" class="modal-form" enctype="multipart/form-data"
                        action="{{ route('user.menu.category.update')}}" method="POST">
                        @csrf
                        <p id="errslug" class="mb-0 text-danger em"></p>
                        
                        <div class="form-group">
                            <div class="col-12 mb-2">
                                <label for="image"><strong>{{ __('Category Image') }} **</strong></label>
                            </div>
                            <div class="col-md-12 showImage mb-3">
                                <img src="{{ $data->image ? asset('assets/admin/img/categories/' . $data->image) : asset('assets/admin/img/noimage.jpg') }}" alt="..." class="img-thumbnail">
                            </div>
                            <input type="file" name="image" id="image" class="form-control">
                            <p id="errimage" class="mb-0 text-danger em"></p>
                        </div>
    
                        <div class="form-group">
                            <label for="">Name **</label>
                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" placeholder="Enter name">
                            <p id="errname" class="mb-0 text-danger em"></p>
                        </div>
                        <input type="hidden" name="category_id" value="{{ $data->id }}">
    
                        <div class="form-group">
                            <label for="">Status **</label>
                            <select class="form-control ltr" name="status">
                                <option value="" selected disabled>Select a status</option>
                                <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
                            </select>
                            <p id="errstatus" class="mb-0 text-danger em"></p>
                        </div>
                    </form>
                </div>

                <div class="modal-footer mb-4 d-flex jusstify-content-center align-items-center">
                    <button id="submitBtn" type="button" class="btn btn-success">Update</button>
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
