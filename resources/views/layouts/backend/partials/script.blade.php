<!-- Scripts -->
<!-- <script src="{{ asset('assets/dashui/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script> -->
<!-- Libs JS -->
<!-- <script src="{{ asset('assets/dashui/libs/jquery/dist/jquery.min.js') }}"></script> -->
<!-- <script src="{{ asset('assets/vendor/cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') }}" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
<!-- <script src="{{ asset('assets/dashui/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script> -->
<!-- <script src="{{ asset('assets/dashui/libs/feather-icons/dist/4.28.0/feather.min.js') }}"></script> -->
<script src="{{ asset('assets/backend/js/simplebar.min.js') }}"></script>
<!-- <script type="text/javascript" charset="utf8" src="{{ asset('assets/dashui/libs/flatpickr/dist/flatpickr.min.js') }}"></script> -->


<!-- Theme JS -->
<script src="{{ asset('assets/backend/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/theme.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/notify.js') }}"></script>
<script>
    $(document).ready(function() {
        $('body').on('hidden.bs.modal', '.modal', function () {
            var form = $(this).find('form');
            if (form.length > 0) {
                form[0].reset();
            }
        });
    });
</script>
