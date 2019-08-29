<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if(session('success') || session('failed') || session('info') || session('warning'))
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
@endif

@if(session('success'))
<script>
    toastr["success"]("{!! session('success') !!}");
</script>
@endif

@if(session('failed'))
<script>
    toastr["error"]("{{ session('failed') }}");
</script>
@endif

@if(session('info'))
<script>
    toastr["info"]("{{ session('info') }}")
</script>
@endif

@if(session('warning'))
<script>
    toastr["warning"]("{{ session('warning') }}")
</script>
@endif