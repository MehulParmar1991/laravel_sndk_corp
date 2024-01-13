<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laravel</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
        <link rel='stylesheet'
              href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #04AA6D;
  color: white;
}
</style>
    </head>
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                        </div>
                        <div class="my-2">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" placeholder="Product" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" name="brand_name" class="form-control" placeholder="Brand" required>
                        </div>
                        <div class="my-2">
                            <label for="category">Category</label>
                            <!-- <input type="text" name="category" class="form-control" placeholder="Category" required> -->
                            <select  id="country-dropdown" name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $data)
                                <option value="{{$data->id}}">
                                    {{$data->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-2">
                            <label for="sub_category">Sub Category</label>            
                            <select id="city-dropdown" name="sub_category_id" class="form-control" required></select>
                        </div>
                        <!--<div class="my-2">
                            <label for="product_attributes">Product Details</label>
                            <div class="col-md-2 input-group repeatDiv" id="repeatDiv">
                                <input type="number" class="form-control" name="sizes[]" placeholder="Size">
                                <input type="number" class="form-control" name="item_prices[]" placeholder="Item price">
                                <input type="number" class="form-control" name="discounted_prices[]" placeholder="Discounted price">
                            </div>
                            <br>
                            <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More</button>
                        </div>-->
                        <div class="my-2">
                            <div class="form-group fieldGroup">
                                <label for="product_attributes">Product Details</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="sizes[]" class="form-control" placeholder="Size"/>
                                    <input type="text" name="item_prices[]" class="form-control" placeholder="Item price"/>
                                    <input type="text" name="discounted_prices[]" class="form-control" placeholder="Discounted price"/>
                                    <span class="input-group-text">
                                        <a href="javascript:void(0);" class="btn btn-success addMore">
                                            <i class="custicon plus"></i> Add
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="my-2">
                            <label for="post">Product Images</label>
                            <input type="file" name="files[]" class="form-control" placeholder="Post" required multiple>
                        </div>
                        <div class="my-2">
                            <label for="avatar">Featured Image</label>
                            <input type="file" name="avatar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add new product modal end --}}

    {{-- edit product modal start --}}
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <input type="hidden" name="emp_avatar" id="emp_avatar">
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                        </div>
                        <div class="my-2">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Brand" required>
                        </div>
                        <div class="my-2">
                            <label for="category">Category</label>
                            <!-- <input type="text" name="category" class="form-control" placeholder="Category" required> -->
                            <select  id="country-dropdown" name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $data)
                                <option value="{{$data->id}}">
                                    {{$data->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="my-2">
                            <label for="sub_category">Sub Category</label>            
                            <select id="city-dropdown" name="sub_category_id" class="form-control"></select>
                        </div>
                        <div class="my-2">
                            <label for="product_attributes">Product Details</label>
                            <div class="col-md-2 input-group repeatDiv" id="repeatDiv">
                                <input type="text" class="form-control" name="sizes[]" placeholder="Size">
                                <input type="text" class="form-control" name="item_prices[]" placeholder="Item price">
                                <input type="text" class="form-control" name="discounted_prices[]" placeholder="Discounted price">
                            </div>
                            <br>
                            <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More</button>
                        </div>
                        <div class="my-2">
                            <label for="files">Product Images</label>
                            <input type="file" name="files[]" class="form-control" placeholder="Post" required multiple>
                        </div>
                        <div class="mt-2" id="files">  
                        </div>
                        <div class="my-2">
                            <label for="avatar">Featured Image</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>
                        <div class="mt-2" id="avatar">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <body class="bg-light">
        <div class="topnav">
        <a href="{{ route('dashboard') }}">Home</a>
        <a href="{{ route('categories') }}">Categories</a>
        <a class="active" href="{{ route('products') }}">Products</a>
        <a href="{{ route('logout') }}">Logout</a>
        </div>
        <div class="container">
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                            <h3 class="text-light">Products</h3>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                                    class="bi-plus-circle me-2"></i>Add New Product</button>
                                
                        </div>
                        <div class="card-body" id="show_all_employees">
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
      $(function() {
         var selectedCategoryId = {{ $selectedCategoryId ?? 'null' }};
         populateCategories(selectedCategoryId);
         function populateCategories(selectedCategoryId) {
            // Make an Ajax request to fetch categories
            $.ajax({
                url: '{{ route('populateCategories') }}',
                type: 'GET',
                success: function(response) {
                    // Populate the category dropdown with fetched data using Blade
                    var dropdown = $('#country-dropdown');
                    dropdown.empty();
                    
                    dropdown.append('<option value="">-- Select Category --</option>');
                    @foreach ($categories as $data)
                        dropdown.append('<option value="{{$data->id}}">{{$data->name}}</option>');
                    @endforeach

                    if (selectedCategoryId) {
                        dropdown.val(selectedCategoryId);
                    } else {
                        // If no selected category ID provided, set the default value
                        // For example, set a random category as selected
                        //var randomIndex = Math.floor(Math.random() * response.length);
                        //dropdown.val(response[randomIndex].id);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
      // add new employee ajax request
      $("#add_employee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_employee_btn").text('Adding...');
      $.ajax({
      url: '{{ route('store') }}',
              method: 'post',
              data: fd,
              cache: false,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
              if (response.status == 200) {
              Swal.fire(
                      'Added!',
                      'Product Added Successfully!',
                      'success'
                      )
                      fetchAllEmployees();
              }
              $("#add_employee_btn").text('Add Product');
              $("#add_employee_form")[0].reset();
              $("#addEmployeeModal").modal('hide');
              }
      });
      });
      // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
      url: '{{ route('edit') }}',
              method: 'get',
              data: {
              id: id,
                      _token: '{{ csrf_token() }}'
              },
              success: function(response) {

              $("#product_name").val(response.product_name);
              $("#brand_name").val(response.brand_name);
              //alert(response.category_id)
              //populateCategories(response.category_id);
              var avatarContainer = $("#files");
              avatarContainer.empty();

              var productImagesString = JSON.stringify(response.product_images);
              var productImages = JSON.parse(productImagesString);
              productImages.forEach(function (imgVal) {
                var imagUrl = response.id + '/'+ imgVal.image;
                var productImagId = response.id + '/'+ imgVal.id;                
                avatarContainer.append(
                    `<div><img src="storage/images/${imagUrl}" width="100" class="img-fluid img-thumbnail"><button type="button" class="btn btn-danger remove-button" data-id="${productImagId}"><i class="bi bi-trash"></i></button></div>`
               );
              });
              $("#avatar").html(
                      `<img src="storage/images/${response.avatar}" width="100" class="img-fluid img-thumbnail">`);
              $("#emp_id").val(response.id);
              $("#emp_avatar").val(response.avatar);
              }
      });
      });

    var avatarContainer = $("#files");
    avatarContainer.on('click', '.remove-button', function () {
        var productImageId = $(this).data('id');
        console.log('Remove button clicked for image with ID: ' + productImageId);
        // Add your logic for image removal here using the captured productImageId
        // For example, you can use an AJAX request to remove the image from the server
        $.ajax({
            url: '{{ route('deleteProductImage') }}',
            method: 'post',
            data: {
                id: productImageId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Handle success response
                console.log('Image removed successfully.');
            },
            error: function(error) {
                // Handle error response
                console.log('Error removing image: ' + error);
            }
        });

        // Remove the image element from the DOM
        $(this).closest('div').remove();
      });

      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_employee_btn").text('Updating...');
      $.ajax({
      url: '{{ route('update') }}',
              method: 'post',
              data: fd,
              cache: false,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response) {
              if (response.status == 200) {
              Swal.fire(
                      'Updated!',
                      'Product Updated Successfully!',
                      'success'
                      )
                      fetchAllEmployees();
              }
              $("#edit_employee_btn").text('Update Employee');
              $("#edit_employee_form")[0].reset();
              $("#editEmployeeModal").modal('hide');
              }
      });
      });
      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
      title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
      if (result.isConfirmed) {
      $.ajax({
      url: '{{ route('delete') }}',
              method: 'delete',
              data: {
              id: id,
                      _token: csrf
              },
              success: function(response) {
              console.log(response);
              Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                      )
                      fetchAllEmployees();
              }
      });
      }
      })
      });

      $('#country-dropdown').on('change', function () {
        var idCountry = this.value;
        $("#city-dropdown").html('');
          $.ajax({
          url: "{{url('api/fetch-cities')}}",
                  type: "POST",
                  data: {
                  category_id: idCountry,
                          _token: '{{csrf_token()}}'
                  },
                  dataType: 'json',
                  success: function (result) {
                  $('#city-dropdown').html('<option value="">-- Select Sub Category --</option>');
                  $.each(result.sub_categories, function (key, value) {
                  $("#city-dropdown").append('<option value="' + value
                          .id + '">' + value.name + '</option>');
                  });
                  }
          });
      });

      // fetch all employees ajax request
      fetchAllEmployees();
      function fetchAllEmployees() {
      $.ajax({
      url: '{{ route('fetchAll') }}',
              method: 'get',
              success: function(response) {
              $("#show_all_employees").html(response);
              $("table").DataTable({
              order: [0, 'desc']
              });
              }
      });
      }

        // Add more group of input fields
        $(".addMore").click(function(){
            var html = '<div class="input-group mb-3"><input type="text" name="sizes[]" class="form-control" placeholder="Size"/><input type="text" name="item_prices[]" class="form-control" placeholder="Item price"/><input type="text" name="discounted_prices[]" class="form-control" placeholder="Discounted price"/><span class="input-group-text"><a href="javascript:void(0);" class="btn btn-danger remove"><i class="custicon minus"></i> Remove</a></span></div>';

            $(".fieldGroup").last().after(html);
        });
        $(document).on('click', '.remove', function(){
            $(this).closest('.input-group').remove();
        });
      });
        </script>
    </body>
</html>