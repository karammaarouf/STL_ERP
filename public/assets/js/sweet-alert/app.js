var SweetAlert_custom = {
    init: function () {
        document.querySelectorAll(".sweet-5").forEach((button) => {
            button.addEventListener("click", function () {
                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع عن هذا الأمر لاحقاً!",
                    icon: "warning",
                    buttons: {
                        cancel: "إلغاء",
                        confirm: "تأكيد",
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        swal("تمت العملية بنجاح!", {
                            icon: "success",
                            buttons: {
                                confirm: "موافق",
                            },
                        }).then(() => {
                            button.closest("form").submit();
                        });
                    } else {
                        swal("تم إلغاء العملية بأمان!");
                    }
                });
            });
        });
    },
};
(function ($) {
    SweetAlert_custom.init();
})(jQuery);
