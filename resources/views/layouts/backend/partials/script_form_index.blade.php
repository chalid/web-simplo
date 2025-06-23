<script>
    function isSuperAdmin() {
        var currentUser = {!! json_encode(Auth::user()) !!};
        // Add your logic to check if the current user is a Super Admin
        // This can be based on roles or any other criteria specific to your application
        // For example, if you have a "role" property on the user object:
        return currentUser.roles.some(role => role.name === 'Super Admin');
    }

    function checkPermission(permission, callback) {
        // Make an AJAX request to your server to check if the user has the specified permission
        // Replace 'check_permission_endpoint' with the actual endpoint to check permissions on your server
        $.ajax({
            url: '/admin/check_permission',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { permission: permission },
            success: function(response) {
                if (response && response.hasPermission) {
                    callback(true);
                } else {
                    callback(false);
                }
            },
            error: function() {
                // Handle error
                callback(false);
            }
        });
    }

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })();

    function confirm_destroy(form){
        var c = confirm("{{ $confirmDelete }}");
        if(c){
            form.submit();
        }else{
            return false;
        }
    };
</script>