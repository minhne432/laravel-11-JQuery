$(document).ready(function () {
    // Lấy CSRF token từ thẻ meta
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    // Khởi tạo DataTable
    $("#category-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: routes.categoriesIndex,
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "type" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    // Sự kiện click cho nút thêm mới danh mục
    $("#addCategory").click(function () {
        $("#name").val("");
        $("#type").val(null); // Đặt giá trị của thẻ select về tùy chọn mặc định
    });

    // Sự kiện click cho nút lưu danh mục mới
    var form = $("#ajaxForm");

    $("#saveBtn").click(function () {
        var formData = new FormData(form[0]);
        $.ajax({
            url: routes.categoriesStore,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                $(".ajax-modal").modal("hide");
                Swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                });
                $("#category-table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Sự kiện click cho nút chỉnh sửa danh mục
    $("body").on("click", ".editButton", function () {
        var id = $(this).data("id");

        $.ajax({
            url: routes.categoriesEdit(id),
            method: "GET",
            success: function (response) {
                // Hiển thị modal chỉnh sửa và điền giá trị vào các trường input
                $("#editModal").modal("show");
                $("#editModalLabel").html("Edit Category");
                $("#saveEditBtn").html("Update");
                $("#edit_category_id").val(response.id);
                $("#edit_name").val(response.name);
                $("#edit_type").val(response.type);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Sự kiện click cho nút cập nhật danh mục
    var formUpdate = $("#editForm");

    $("#saveEditBtn").click(function () {
        var formData = new FormData(formUpdate[0]);
        $.ajax({
            url: routes.categoriesUpdate,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "X-HTTP-Method-Override": "PUT", // Override method to PUT
            },
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                $("#editModal").modal("hide");
                Swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                });
                $("#category-table").DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    //
    $("body").on("click", ".deleteButton", function () {
        var id = $(this).data("id");

        // Show confirm modal
        $("#deleteModal").modal("show");

        $("#confirmDeleteBtn").click(function () {
            $.ajax({
                url: "{{route('categories.delete',['id' => " + id + "])}}",
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#deleteModal").modal("hide");
                    Swal.fire({
                        title: "Category deleted",
                        text: response.success,
                        icon: "success",
                    });

                    $("#category-table").DataTable().ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });
    });
});
