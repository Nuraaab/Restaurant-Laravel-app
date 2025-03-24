@extends('layout.layout')
@php
    $title='Edit Item';
    $subTitle = 'Edit Item';
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
            <h5>Edit Item</h5>
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
            
            {{-- Slider images upload start --}}
            <div class="px-2">
                <label for="" class="mb-2"><strong>{{ __('Slider Images') }} *</strong></label>
                <div class="row mb-5">
                    <div class="col-12 p-0">
                        <div class="image-gallery">
                            @if (!is_null($galleries))
                                @foreach ($galleries as $key => $img)
                                    <div class="image-container">
                                        <img class="slider-image"
                                            src="{{ asset('assets/admin/img/items/slider-images/' . $img) }}"
                                            alt="Item Image">
                                        <button type="button" class="close-btn btn btn-danger rmvbtndb"
                                            onclick="rmvdbimg({{ $key }}, '{{ $item->id }}', '{{ $img }}')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <form action="{{ route('user.item.slider') }}" id="my-dropzone"
                    enctype="multipart/form-data" class="dropzone create">
                    @csrf
                    <div class="fallback"></div>
                </form>
                @if ($errors->has('image'))
                    <p class="mt-2 mb-0 text-danger">{{ $errors->first('image') }}</p>
                @endif
            </div>
            {{-- Slider images upload end --}}


                <form id="itemForm" class="" action="{{ route('user.menu.item.update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    {{-- START: Featured Image --}}
                    <div class="form-group">
                        <div class="col-12 mb-2">
                            <label for="image"><strong>{{ __('Thumbnail') }} *</strong></label>
                        </div>
                        <div class="col-md-12 showImage mb-3">
                            <img src="{{ isset($item->thumbnail) ? asset('assets/admin/img/items/thumbnail/' . $item->thumbnail) : asset('assets/admin/img/noimage.jpg') }}"
                                            alt="..." class="img-thumbnail">
                        </div>
                        <input type="file" name="thumbnail" value="{{$item->thumbnail}}" id="image" class="form-control">
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
                                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Show</option>
                                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Hide</option>
                                </select>
                                <p id="errstatus" class="mb-0 text-danger em"></p>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Price*</label>
                                <input type="number" class="form-control ltr" name="price" min ="1" step ="1"
                                    value="{{$item->price}}" placeholder="Enter Current Price">
                                <p id="errprice" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        @php
                            $categories = App\Models\Category::where('status', 1)
                                ->orderBy('name', 'asc')
                                ->get();
                            $selectedCategories = $item->categories->pluck('id')->toArray() ?? [];
                        @endphp
                        


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label d-block">{{ ('Select Category*') }}</label>
                                <div class="selectgroup selectgroup-pills">
                                    @foreach ($categories as $category)
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                                class="selectgroup-input category-checkbox" 
                                                {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
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
                                    value="{{$item->name}}"
                                    placeholder="{{ __('Enter Name') }}">
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-12">
                            <div
                                class="form-group">
                                <label>{{ __('Description') }}</label>
                                <textarea id="postContent" class="form-control summernote"
                                    name="description" placeholder="{{ __('Enter Content') }}" data-height="300">{{$item->description}}</textarea>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-footer mb-4 d-flex jusstify-content-center align-items-center">
        <button form="itemForm" type="submit" class="btn btn-success">Update</button>
    </div>
</div>



    
@endsection

  
