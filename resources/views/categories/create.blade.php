<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    {{-- Sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js">
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create categories</title>
</head>

<body>

   <!-- Modal for Add Category -->
    <div class="modal fade ajax-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="" id="ajaxForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Name:</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span id="nameError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="">Type:</label>
                            <select id="type" name="type" class="form-control">
                                <option disabled selected>Choose Option</option>
                                <option value="food">Food</option>
                                <option value="fashion">Fashion</option>
                                <option value="book">Book</option>
                                <option value="sport">Sport</option>
                            </select>
                            <span id="typeError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Modal for Edit Category -->
    <div class="modal fade edit-modal" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <form action="" id="editForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_category_id" name="category_id" value="">
                        <div class="form-group mb-3">
                            <label for="edit_name">Name:</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <span id="edit_nameError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="edit_type">Type:</label>
                            <select id="edit_type" name="type" class="form-control">
                                <option disabled selected>Choose Option</option>
                                <option value="food">Food</option>
                                <option value="fashion">Fashion</option>
                                <option value="book">Book</option>
                                <option value="sport">Sport</option>
                            </select>
                            <span id="edit_typeError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveEditBtn">Update category</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info" id="addCategory" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Add category
            </button>
            <table id="category-table" class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            // get CSRF token from meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $("#category-table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


                $("#modal-title").html("Create category");
                $("#saveBtn").html("Save category");


            //store
            var form = $("#ajaxForm");

            $("#saveBtn").click(function() {
                var formData = new FormData(form[0]);
                $.ajax({
                    url: '{{ route('categories.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $(".ajax-modal").modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: response.success,
                            icon: "success"
                        });
                        $('#category-table').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Edit button code
            $(document).ready(function() {
                $('body').on('click', '.editButton', function() {
                    var id = $(this).data('id');

                    $.ajax({
                        url: '{{ url('categories', '') }}' + '/' + id + '/' + 'edit',
                        method: 'GET',
                        success: function(response) {
                            // Điền giá trị vào các trường input
                            $('#edit_category_id').val(response.id);
                            $('#edit_name').val(response.name);
                            $('#edit_type').val(response.type);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });

            //update
            var formUpdate = $('#editForm');

            $("#saveEditBtn").click(function() {
                var formData = new FormData(formUpdate[0]);
                $.ajax({
                    url: '{{ route('categories.update') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT' // Override method to PUT
                    },
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $(".edit-modal").modal('hide');
                        Swal.fire({
                            title: "Success",
                            text: response.success,
                            icon: "success"
                        });
                        $('#category-table').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>

</html>
