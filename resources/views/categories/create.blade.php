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
    {{-- Yajra Datatable --}}
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
                        <h5 class="modal-title" id="modal-title">Create category</h5>
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
                        <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Modal for Edit Category -->
    <div class="modal fade edit-modal" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
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

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px">
            <!-- Button trigger Add Category modal -->
            <button type="button" class="btn btn-info" id="addCategory" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Add category
            </button>
            <table id="category-table" class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
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
        var routes = {
            categoriesIndex: "{{ route('categories.index') }}",
            categoriesStore: "{{ route('categories.store') }}",
            categoriesUpdate: "{{ route('categories.update') }}",
            categoriesEdit: function(id) {
                return '{{ url('categories') }}/' + id + '/edit';
            }
        };
    </script>

    <script src="{{ asset('js/pages/category.js') }}"></script>

</body>

</html>
