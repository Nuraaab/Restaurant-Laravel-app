(function ($) {
  'use strict';

  //  image (id) preview js/
  $(document).on('change', '#image', function (event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.showImage img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  })
  //  image (class) preview js/
  $(document).on('change', '.image', function (event) {
    let $this = $(this);
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      $this.prev('.showImage').children('img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  });

  // displaying error messages
  $(document).on('click', '#submitBtn', function (e) {
    console.log('Hiiiii');
    $(e.target).attr('disabled', true);

    console.log('loader', $(".request-loader"));
    $(".request-loader").addClass("show");

    let ajaxForm = document.getElementById('ajaxForm');
    let fd = new FormData(ajaxForm);
    let url = $("#ajaxForm").attr('action');
    let method = $("#ajaxForm").attr('method');

    if ($("#ajaxForm .summernote").length > 0) {
      $("#ajaxForm .summernote").each(function (i) {
        let content = $(this).summernote('isEmpty') ? '' : $(this).summernote('code');

        fd.delete($(this).attr('name'));
        fd.append($(this).attr('name'), content);
      });
    }

    $.ajax({
      url: url,
      method: method,
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log('success', typeof data.error);
        console.log('data: ', data.error);
        $(e.target).attr('disabled', false);
        $(".request-loader").removeClass("show");

        $(".em").each(function () {
          $(this).html('');
        })
        console.log('Data: ', data);
        if (data == "warning") {
          location.reload();
        }
        if (data == "success") {
          console.log('data: ');
          location.reload();
        }
       

        // if error occurs
        else if (typeof data.error != 'undefined') {
          for (let x in data) {
            console.log('value of x', x);
            if (x == 'error') {
              continue;
            }
            document.getElementById('err' + x).innerHTML = data[x][0];
            
          }
        }
      },
      error: function (error) {

        $(".em").each(function () {
          $(this).html('');
        })
        console.log('error' ,error.responseJSON.errors);
        for (let x in error.responseJSON.errors) {
          document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
        }
        $(".request-loader").removeClass("show");
        $(e.target).attr('disabled', false);
      }
    });
  });


  // delete confirm button
  $('.deletebtn').on('click', function (e) {
    e.preventDefault();

    $(".request-loader").addClass("show");

    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      buttons: {
        confirm: {
          text: 'Yes, delete it!',
          className: 'btn btn-success'
        },
        cancel: {
          visible: true,
          className: 'btn btn-danger'
        }
      }
    }).then((Delete) => {
      if (Delete) {
        $(this).parent(".deleteform").trigger('submit');
      } else {
        swal.close();
        $(".request-loader").removeClass("show");
      }
    });
  });

   // insertitem
   $('#itemForm').on('submit', function (e) {
    console.log('hiiii');
    $('.request-loader').addClass('show');
    e.preventDefault();

    let action = $('#itemForm').attr('action');
    let fd = new FormData(document.querySelector('#itemForm'));

    $.ajax({
        url: action,
        method: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log('Post Form', data);
            $('.request-loader').removeClass('show');
            if (data == 'success') {
                window.location = fullUrl;
            }
        },
        error: function (error) {
            console.log('error : ', error);

            let errors = ``;
            for (let x in error.responseJSON.errors) {
                errors += `<li>
                    <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
                </li>`;
            }

            $('#postErrors ul').html(errors);
            $('#postErrors').fadeIn().addClass('show'); // Show alert and add fade-in effect

            $('.request-loader').removeClass('show');

            $('html, body').animate({
                scrollTop: $('#postErrors').offset().top - 100
            }, 1000);
        }
    });
});




// flash sale model  active / deactive

$(document).on('change', '.manageFlash', function (e) {
  console.log('hellooo');
  var $val = $(this).val();
  var $itemId = $(this).attr('data-item-id');
  
  // Get the CSRF token from the meta tag
  var csrfToken = $('meta[name="csrf-token"]').attr('content');
  console.log('token', csrfToken);
  if ($val == 0) {
    let url = $("#flashForm" + $itemId).attr('action');
    let method = $("#flashForm" + $itemId).attr('method');
    
    console.log(url);
    
    $.ajax({
      url: url,
      method: method,
      data: {
        itemId: $itemId, 
        val: $val,
        _token: csrfToken  // Include the CSRF token here
      },
      success: function (data) {
        if (data == "success") {
          location.reload();
        }
      },
      error: function (error) {
        $(".request-loader").removeClass("show");
      }
    });
  } else {
    $("#flashmodal" + $itemId).modal('show');
  }
});





  // sidebar submenu collapsible js
  $(".sidebar-menu .dropdown").on("click", function(){
    var item = $(this);
    item.siblings(".dropdown").children(".sidebar-submenu").slideUp();

    item.siblings(".dropdown").removeClass("dropdown-open");

    item.siblings(".dropdown").removeClass("open");

    item.children(".sidebar-submenu").slideToggle();

    item.toggleClass("dropdown-open");
  });

  $(".sidebar-toggle").on("click", function(){
    $(this).toggleClass("active");
    $(".sidebar").toggleClass("active");
    $(".dashboard-main").toggleClass("active");
  });

  $(".sidebar-mobile-toggle").on("click", function(){
    $(".sidebar").addClass("sidebar-open");
    $("body").addClass("overlay-active");
  });

  $(".sidebar-close-btn").on("click", function(){
    $(".sidebar").removeClass("sidebar-open");
    $("body").removeClass("overlay-active");
  });

  //to keep the current page active
  $(function () {
    for (
      var nk = window.location,
        o = $("ul#sidebar-menu a")
          .filter(function () {
            return this.href == nk;
          })
          .addClass("active-page") // anchor
          .parent()
          .addClass("active-page");
      ;

    ) {
      // li
      if (!o.is("li")) break;
      o = o.parent().addClass("show").parent().addClass("open");
    }
  });

/**
* Utility function to calculate the current theme setting based on localStorage.
*/
function calculateSettingAsThemeString({ localStorageTheme }) {
  if (localStorageTheme !== null) {
    return localStorageTheme;
  }
  return "light"; // default to light theme if nothing is stored
}

/**
* Utility function to update the button text and aria-label.
*/
function updateButton({ buttonEl, isDark }) {
  const newCta = isDark ? "dark" : "light";
  buttonEl.setAttribute("aria-label", newCta);
  buttonEl.innerText = newCta;
}

/**
* Utility function to update the theme setting on the html tag.
*/
function updateThemeOnHtmlEl({ theme }) {
  document.querySelector("html").setAttribute("data-theme", theme);
}

/**
* 1. Grab what we need from the DOM and system settings on page load.
*/
const button = document.querySelector("[data-theme-toggle]");
const localStorageTheme = localStorage.getItem("theme");

/**
* 2. Work out the current site settings.
*/
let currentThemeSetting = calculateSettingAsThemeString({ localStorageTheme });

/**
* 3. If the button exists, update the theme setting and button text according to current settings.
*/
if (button) {
  updateButton({ buttonEl: button, isDark: currentThemeSetting === "dark" });
  updateThemeOnHtmlEl({ theme: currentThemeSetting });

  /**
  * 4. Add an event listener to toggle the theme.
  */
  button.addEventListener("click", (event) => {
    const newTheme = currentThemeSetting === "dark" ? "light" : "dark";

    localStorage.setItem("theme", newTheme);
    updateButton({ buttonEl: button, isDark: newTheme === "dark" });
    updateThemeOnHtmlEl({ theme: newTheme });

    currentThemeSetting = newTheme;
  });
} else {
  // If no button is found, just apply the current theme to the page
  updateThemeOnHtmlEl({ theme: currentThemeSetting });
}


// =========================== Table Header Checkbox checked all js Start ================================
$('#selectAll').on('change', function () {
  $('.form-check .form-check-input').prop('checked', $(this).prop('checked')); 
}); 

  // Remove Table Tr when click on remove btn start
  $('.remove-btn').on('click', function () {
    $(this).closest('tr').remove(); 

    // Check if the table has no rows left
    if ($('.table tbody tr').length === 0) {
      $('.table').addClass('bg-danger');

      // Show notification
      $('.no-items-found').show();
    }
  });


  $(".datapicker").flatpickr({
    enableTime: false,  
    dateFormat: "Y-m-d", 
    altInput: true, 
    altFormat: "F j, Y",
    minDate: null, 
    disableMobile: true
});

$(".timepicker").flatpickr({
  enableTime: true,  
  noCalendar: true,  
  dateFormat: "H:i",
  altInput: true, 
  altFormat: "h:i K",
  minDate: "00:00",
  maxDate: "23:59",
  disableMobile: true
});


     // flash Sale form
  $(document).on('click', '.submitBtn', function (e) {
    $(e.target).attr('disabled', true);
    var $id = $(this).attr('data-id')
    $(".request-loader").addClass("show");

    let modalform = document.getElementById('modalform' + $id);
    let fd = new FormData(modalform);
    let url = $("#modalform" + $id).attr('action');
    let method = $("#modalform" + $id).attr('method');

    $.ajax({
      url: url,
      method: method,
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {

        // console.log(data, 'success', typeof data.error);
        $(e.target).attr('disabled', false);
        $(".request-loader").removeClass("show");

        $(".em").each(function () {
          $(this).html('');
        })
        if (data == "success") {

          location.reload();
        }
        // if error occurs
        else if (typeof data.error != 'undefined') {

          for (let x in data) {
            if (x == 'error') {
              continue;
            }
            $("#modalform" + $id).find('#err' + x).text(data[x][0]);
          }
        }
      },
      error: function (error) {

        $(".em").each(function () {
          $(this).html('');
        })
        console.log(error.responseJSON.errors);
        for (let x in error.responseJSON.errors) {
          $("#modalform" + $id).find('#err' + x).text(error.responseJSON.errors[x][0]);
        }
        $(".request-loader").removeClass("show");
        $(e.target).attr('disabled', false);
      }
    });
  });

  
  // Remove Table Tr when click on remove btn end
})(jQuery);