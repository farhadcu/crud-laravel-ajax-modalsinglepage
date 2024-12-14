@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Product List</h2>

        <!-- Button to trigger Create Product Modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>

        <!-- Search and Sort -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by ID or description" />
                    <button class="btn btn-primary">Search</button>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select" aria-label="Sort by options">
                    <option selected disabled>Sort by...</option>
                    <option value="price">Price</option>
                    <option value="name">Name</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered" id="allProductsTableId">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th>Product Id</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    @forelse ($products as $product)
                        <tr class="text-center align-middle">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <img src="{{ $product->image }}" alt="Product Image" class="img-thumbnail"
                                    style="width: 50px; height:50px" />
                            </td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm text-white view"
                                    data-id={{ $product->id }}>View</a>
                                <a href="#" class="btn btn-warning btn-sm text-white edit"
                                    data-id={{ $product->id }}>Edit</a>
                                <a href="#" class="btn btn-danger btn-sm delete"
                                    data-id={{ $product->id }}>Delete</a>
                            </td>
                        </tr>
                    @empty
                        <h2>No data available</h2>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addProductForm">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">
                            Create Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" id="name" class="form-control" name="name"
                                placeholder="Enter product name" />
                            <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" class="form-control" rows="3" name="description"
                                placeholder="Enter product description"></textarea>
                            <span class="text-danger" id="descriptionError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" id="price" class="form-control" name="price"
                                placeholder="Enter price" step="0.01" />
                            <span class="text-danger" id="priceError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control" />
                            <span class="text-danger" id="imageError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Create Product
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Product Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewProductModalLabel">View Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Id</th>
                            <td><span id="view_id"></span></td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td><span id="view_name"></span></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><span id="view_description"></span></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td><span id="view_price"></span></td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                <img src="https://via.placeholder.com/150" alt="Product Image" id="view_image"
                                    class="img-thumbnail" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editProductForm">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">
                            Edit Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Product Name</label>
                            <input type="text" id="edit_name" class="form-control" name="name" value="" />
                            <span class="text-danger" id="edit_nameError"></span>
                            <input type="hidden" id="edit_id" />
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea id="edit_description" class="form-control" name="description" rows="3"></textarea>
                            <span class="text-danger" id="edit_descriptionError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" id="edit_price" class="form-control" name="price" value=""
                                step="0.01" />
                            <span class="text-danger" id="edit_priceError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Image</label>
                            <!-- Existing image -->
                            <div class="mb-3 text-center">
                                <img id="edit_image" src="https://via.placeholder.com/150" alt="Current Product Image"
                                    class="img-thumbnail mb-3" style="width: 150px; height:150px" />
                            </div>
                            <!-- File input for uploading a new image -->
                            <input type="file" class="form-control" name="image" id="updated_image" />
                            <span class="text-danger" id="edit_imageError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary update">
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Add Product
            $('#addProductForm').submit(function(e) {
                e.preventDefault();
                let addFormData = new FormData(this);

                $.ajax({
                    url: '/products',
                    method: 'POST',
                    data: addFormData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addProductForm')[0].reset();
                        $('#addProductModal').modal('hide');
                        $('.table-responsive').load(location.href +
                            ' .table-responsive'); //must use space before id/class
                    },
                    error: function(error) {
                        $('#nameError').text('');
                        $('#descriptionError').text('');
                        $('#priceError').text('');
                        $('#imageError').text('');
                        $('#nameError').text(error.responseJSON.errors.name);
                        $('#descriptionError').text(error.responseJSON.errors.description);
                        $('#priceError').text(error.responseJSON.errors.price);
                        $('#imageError').text(error.responseJSON.errors.image);
                    }
                });

            });

            // View Product
            $(document).on('click', '.view', function(e) {
                e.preventDefault();
                let product = $(this).data('id');
                $('#viewProductModal').modal('show');

                $.ajax({
                    url: `/products/${product}`,
                    method: 'GET',
                    success: function(response) {
                        $('#view_id').text(product);
                        $('#view_name').text(response.item.name);
                        $('#view_description').text(response.item.description);
                        $('#view_price').text(response.item.price);
                        $('#view_image').attr('src', response.item.image);
                    },
                    error: function(error) {

                    }
                });

            });

            // Edit Product
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                let product = $(this).data('id');
                $('#editProductModal').modal('show');

                $.ajax({
                    url: `/products/${product}/edit`,
                    method: 'GET',
                    success: function(response) {
                        $('#edit_name').val(response.item.name);
                        $('#edit_description').val(response.item.description);
                        $('#edit_price').val(response.item.price);
                        $('#edit_image').attr('src', response.item.image);
                        $('#edit_id').val(product);
                    },
                    error: function(error) {

                    }
                });

            });

            // Update Product
            $(document).on('click', '.update', function(e) {
                e.preventDefault();
                let product = $('#edit_id').val();
                let editFormData = new FormData($('#editProductForm')[0]);
                editFormData.append('_method', 'PUT');

                $.ajax({
                    url: `/products/${product}`,
                    method: 'POST',
                    data: editFormData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#editProductForm')[0].reset();
                        $('#editProductModal').modal('hide');
                        $('#allProductsTableId').load(location.href +
                            ' #allProductsTableId');
                    },
                    error: function(error) {
                        $('#edit_nameError').text('');
                        $('#edit_descriptionError').text('');
                        $('#edit_priceError').text('');
                        $('#edit_imageError').text('');
                        $('#edit_nameError').text(error.responseJSON.errors.name);
                        $('#edit_descriptionError').text(error.responseJSON.errors.description);
                        $('#edit_priceError').text(error.responseJSON.errors.price);
                        $('#edit_imageError').text(error.responseJSON.errors.image);
                    }
                });

            });

            // Delete Product
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let product = $(this).data('id');
                if (confirm('Are you sure to delete this item permanently ?')) {
                    $.ajax({
                        url: `/products/${product}`,
                        method: 'DELETE',
                        success: function(response) {
                            $('.table-responsive').load(location.href + ' .table-responsive');
                        },
                        error: function(error) {

                        }
                    });
                }
            });
            //Delete Product ends here

        });
    </script>
@endsection
