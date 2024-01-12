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
                            <!--             <div class="col-lg">
                                          <label for="fname">First Name</label>
                                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                        </div>
                                        <div class="col-lg">
                                          <label for="lname">Last Name</label>
                                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                                        </div> -->
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
                        <div class="my-2">
                            <div class="col-md-2 input-group repeatDiv" id="repeatDiv">
                                <input type="text" class="form-control" name="sizes[]" placeholder="Size">
                                <input type="text" class="form-control" name="item_prices[]" placeholder="Item price">
                                <input type="text" class="form-control" name="discounted_prices[]" placeholder="Discounted price">
                            </div>
                            <br>
                            <button type="button" class="btn btn-info" id="repeatDivBtn" data-increment="1">Add More</button>
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
                            <!--             <div class="col-lg">
                                          <label for="fname">First Name</label>
                                          <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
                                        </div>
                                        <div class="col-lg">
                                          <label for="lname">Last Name</label>
                                          <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
                                        </div> -->
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
                            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>    
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


              var avatarContainer = $("#files");
              avatarContainer.empty();
              response.product_images.forEach(function (imgVal) {
                var imagUrl = response.id + '/'+ imgVal
                avatarContainer.append(
                    `<img src="storage/images/${imagUrl}" width="100" class="img-fluid img-thumbnail">`
               );
              });    
              //$("#files").html(
              //        `<img src="storage/images/${response.avatar}" width="100" class="img-fluid img-thumbnail">`);
              $("#avatar").html(
                      `<img src="storage/images/${response.avatar}" width="100" class="img-fluid img-thumbnail">`);
              $("#emp_id").val(response.id);
              $("#emp_avatar").val(response.avatar);
              }
      });
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

      $("#repeatDivBtn").click(function () {

      $newid = $(this).data("increment");
      $repeatDiv = $("#repeatDiv").wrap('<div/>').parent().html();
      $('#repeatDiv').unwrap();
      $($repeatDiv).insertAfter($(".repeatDiv").last());
      $(".repeatDiv").last().attr('id', "repeatDiv" + '_' + $newid);
      $("#repeatDiv" + '_' + $newid).append('<div class="input-group-append"><button type="button" class="btn btn-danger removeDivBtn" data-id="repeatDiv' + '_' + $newid + '">Remove</button></div><br>');
      $newid++;
      $(this).data("increment", $newid);
      });
      $(document).on('click', '.removeDivBtn', function () {

      $divId = $(this).data("id");
      $("#" + $divId).remove();
      $inc = $("#repeatDivBtn").data("increment");
      $("#repeatDivBtn").data("increment", $inc - 1);
      });
      });
        </script>
    </body>

</html>