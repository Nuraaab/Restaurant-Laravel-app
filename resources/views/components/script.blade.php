    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
    {{-- toaster --}}
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- prism js -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <!-- file upload js -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <!-- audioplayer -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>
    

    <!-- main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

   

    
    @if (session()->has('success'))
    <script>
        "use strict";
        var content = {};
    
        content.message = '{{ session('success') }}';
        content.title = 'Success';
        content.icon = 'ic:baseline-notifications';  // Example of an icon from Iconify
    
        $.notify(content, {
            type: 'success',
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            delay: 4000,
        });
    </script>
    @endif

    @if (session()->has('error'))
    <script>
        "use strict";
        $.notify({
            message: "{{ session('error') }}",
            title: "Error",
            icon: "<i class='fas fa-times-circle'></i>"  
        }, {
            type: 'danger',
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            delay: 4000
        });
    </script>
    @endif
    
    
    @if (session()->has('warning'))
    <script>
        "use strict";
        var content = {};
    
        content.message = '{{ session('warning') }}';
        content.title = "{{ __('Warning!') }}";
        content.icon = 'ic:baseline-warning';  // Example of an icon from Iconify
    
        $.notify(content, {
            type: 'warning',
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            delay: 4000,
        });
    </script>
    @endif
    
    @if (session()->has('info'))
    <script>
        "use strict";
        var content = {};
    
        content.message = '{{ session('info') }}';
        content.title = "{{ __('Information') }}";
        content.icon = 'ic:baseline-info';  // Example of an icon from Iconify
    
        $.notify(content, {
            type: 'info',
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            delay: 4000,
        });
    </script>
    @endif
    


    <?php echo (isset($script) ? $script   : '')?>