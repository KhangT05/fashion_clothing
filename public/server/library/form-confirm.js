(function ($) {
    "use strict";
    var DAMH = {};
    // Xác nhận khi submit form
    DAMH.comfirmSubmit = () => {
        $(document).on('submit', 'form.confirm-submit', function (e) {
            let form = $(this);
            if (form.data('confirmed') === true) {
                return true;
            }
            e.preventDefault();
            let action = form.attr('action');
            let method = form.attr('method');
            let formData = new FormData(form[0]);
            Swal.fire({
                title: 'Xác nhận thao tác',
                text: "Bạn có chắc chắn muốn lưu dữ liệu này?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-check"></i> Xác nhận',
                cancelButtonText: '<i class="fa fa-times"></i> Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.isConfirmed) {
                        form.data('confirmed', true);  // ✅ Set flag
                        form[0].submit();  // ✅ Submit bằng native DOM
                    }
                };
            });
        });
    };
    // xác nhận khi xóa
    DAMH.comfirmDelete = () => {
        $(document).on('click', '.btn-delete, .confirm-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            let url = $(this).attr('href');
            let itemName = $(this).data('name') || 'mục này';

            Swal.fire({
                title: 'Xác nhận xóa',
                html: `Bạn có chắc chắn muốn xóa <strong>${itemName}</strong>?<br><span class="text-danger">Dữ liệu sẽ không thể khôi phục!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<i class="fa fa-trash"></i> Xóa',
                cancelButtonText: '<i class="fa fa-times"></i> Hủy',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    };
    // Xác nhận khi hủy
    DAMH.confirmCancel = () => {
        $(document).on('click', '.btn-cancel, .confirm-cancel', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            // Kiểm tra form có thay đổi không
            let hasChanges = DAMH.checkFormChanges();
            if (hasChanges) {
                Swal.fire({
                    title: 'Bạn có thay đổi chưa lưu',
                    text: "Bạn có chắc chắn muốn hủy? Dữ liệu chưa lưu sẽ bị mất!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<i class="fa fa-times"></i> Hủy và rời đi',
                    cancelButtonText: '<i class="fa fa-arrow-left"></i> Ở lại',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            } else {
                window.location.href = url;
            }
        });
    };
    // Kiểm tra form có thay đổi không
    DAMH.checkFormChanges = () => {
        let hasChanges = false;
        let form = $('form');

        if (form.length) {
            // Lưu giá trị ban đầu khi load trang
            if (!form.data('initial-values')) {
                form.data('initial-values', form.serialize());
            }

            let initialValues = form.data('initial-values');
            let currentValues = form.serialize();

            hasChanges = initialValues !== currentValues;
        }

        return hasChanges;
    };
    $(document).ready(function () {
        DAMH.comfirmSubmit();
        DAMH.comfirmDelete();
        DAMH.confirmCancel();
    })
})(jQuery);