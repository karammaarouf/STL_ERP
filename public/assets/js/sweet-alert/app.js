var SweetAlert_custom = {
    init: function() {
        document.querySelectorAll('.sweet-5').forEach(button => {
            button.addEventListener('click', function () {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        }).then(() => {
                            button.closest('form').submit();
                        });
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                })
            });
        });
    }
};
(function($) {
    SweetAlert_custom.init()
})(jQuery);