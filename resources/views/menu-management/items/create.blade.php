@extends('layout.layout')
@php
    $title='Add Item';
    $subTitle = 'Add Item';
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
    align-items: center; 
}

</style>

<div class="card h-100 p-0 radius-12">
    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
        <div class="d-flex align-items-center flex-wrap gap-3">
            <h5>Add Item</h5>
        </div>
        <a href="{{route('user.menu.item.index')}}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
            <iconify-icon icon="ic:baseline-arrow-back" class="icon text-xl line-height-1"></iconify-icon>
                Back
            </a>

    </div>
    <div class="card-body pt-5 pb-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
             <div class="alert alert-danger pb-1 position-relative fade" 
                id="postErrors" role="alert" style="display: none;">
                <button type="button" class="btn-close position-absolute" 
                        style="top: 5px; right: 10px;" 
                        data-bs-dismiss="alert" aria-label="Close"></button>
                <ul class="mb-0 mt-2"></ul> 
            </div>

           
           
                <div class="px-2">
                    <label for="" class="mb-2"><strong>{{ __('Slider Images') }}
                            *</strong></label>
                    <form action="{{ route('user.item.slider') }}" id="my-dropzone"
                        enctype="multipart/form-data" class="dropzone create">
                        @csrf
                        <div class="fallback">
                        </div>
                    </form>
                    <p class="em text-danger mb-0" id="err_slider_images"></p>
                </div>
                <form id="itemForm" class="" action="{{ route('user.menu.item.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- <input type="hidden" name="type" value="{{ request()->input('type') }}"> --}}

                    {{-- START: Featured Image --}}
                    <div class="form-group">
                        <div class="col-12 mb-2">
                            <label for="image"><strong>{{ __('Thumbnail') }} *</strong></label>
                        </div>
                        <div class="col-md-12 showImage mb-3">
                            <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..."
                                class="img-thumbnail">
                        </div>
                        <input type="file" name="thumbnail" id="image" class="form-control">
                        <p id="errthumbnail" class="mb-0 text-danger em"></p>
                    </div>
                    {{-- END: Featured Image --}}

                    {{-- slider images / --}}
                    <div id="sliders"></div>
                    {{-- slider images / --}}
                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Status *</label>
                                <select class="form-control ltr" name="status">
                                    <option value="" selected disabled>Select a status</option>
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                </select>
                                <p id="errstatus" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Price*</label>
                                <input type="number" class="form-control ltr" name="price" min ="1" step ="1"
                                    value="" placeholder="Enter Current Price">
                                <p id="errprice" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        @php
                            $categories = App\Models\Category::where('status', 1)
                                ->orderBy('name', 'asc')
                                ->get();
                        @endphp
                        


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label d-block">{{ ('Select Category*') }}</label>
                                <div class="selectgroup selectgroup-pills">
                                    @foreach ($categories as $category)
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                                class="selectgroup-input category-checkbox">
                                            <span class="selectgroup-button">{{ $category->name }}</span>
                                        </label>
                                    @endforeach    
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-12">
                            <div
                                class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input type="text" class="form-control"
                                    name="name"
                                    placeholder="{{ __('Enter Name') }}">
                            </div>
                        </div>
                    </div>

                        {{-- <div class="col-lg-12 ">
                            <div
                                class="form-group ">
                                <label for="">Tags </label>
                                <input type="text" class="form-control"
                                    name="tags" value=""
                                    data-role="tagsinput" placeholder="Enter tags">
                            </div>
                        </div> --}}
                        <div class="col-lg-12">
                            <div
                                class="form-group">
                                <label>{{ __('Description') }}</label>
                                <textarea id="postContent" class="form-control summernote"
                                    name="description" placeholder="{{ __('Enter Content') }}" data-height="300"></textarea>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-footer mb-4 d-flex jusstify-content-center align-items-center">
        <button form="itemForm" type="submit" class="btn btn-success">Submit</button>
    </div>
</div>



    
@endsection

  
