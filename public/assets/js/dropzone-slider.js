    "use strict";
    console.log("dropzone");
    console.log(uploadSliderImage);
    Dropzone.options.myDropzone = {
        acceptedFiles: '.png, .jpg, .jpeg',
        url: uploadSliderImage,
        success: function (file, response) {
            $("#sliders").append(`<input type="hidden" name="image[]" id="slider${response.file_id}" value="${response.file_id}">`);
            var removeButton = Dropzone.createElement("<button class='btn btn-xs rmv-btn'><i class='fa fa-times'></i></button>");
            
            var _this = this;
            removeButton.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                _this.removeFile(file);
                rmvImg(response.file_id);
            });
            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);
            if (typeof response.error != 'undefined') {
                if (typeof response.file != 'undefined') {
                    document.getElementById('errpreimg').innerHTML = response.file[0];
                }
            }
        }
    };
    
    function rmvImg(file_Id) {
        console.log('id', file_Id);
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        $.ajax({
            url: rmvSliderImage,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'value': file_Id, '_token': csrf},
            success: function (data) {
                const ele = document.getElementById("slider" + file_Id);
                ele.remove();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    
    function rmvdbimg(key, id, image) {
        console.log('Deleting image:', image);
        $(".request-loader").addClass("show");
    
        $.ajax({
            url: rmvDbSliderImage, // Ensure this is correctly defined
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                key: key,
                id: id,
                image: image
            },
            success: function (data) {
                $(".request-loader").removeClass("show");
    
                // Correctly remove the image div
                $(".image-container").eq(key).fadeOut(300, function () { $(this).remove(); });
    
                // Notification
                var content = {
                    message: 'Slider image deleted successfully!',
                    title: 'Success',
                    icon: 'fa fa-bell'
                };
    
                $.notify(content, {
                    type: 'success',
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    time: 1000,
                    delay: 0,
                });
            },
            error: function () {
                $(".request-loader").removeClass("show");
                alert("Something went wrong! Please try again.");
            }
        });
    }
    
   