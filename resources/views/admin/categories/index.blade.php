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
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                        </div>
                        <div class="my-2">
                            <label for="category_name">Category Name</label>
                            <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add new category modal end --}}

    {{-- edit category modal start --}}
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-body p-4 bg-light">
                        <div class="row">
                        </div>
                        <div class="my-2">
                            <label for="category_name">Category Name</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <body class="bg-light">
        <div class="topnav">
        <a href="{{ route('dashboard') }}">Home</a>
        <a class="active" href="{{ route('categories') }}">Categories</a>
        <a href="{{ route('products') }}">Products</a>
        <a href="{{ route('logout') }}">Logout</a>
        </div>
        <div class="container">
            <div class="row my-5">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                            <h3 class="text-light">Categories</h3>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                                    class="bi-plus-circle me-2"></i>Add New Category</button>                                
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
      url: '{{ route('storeCategory') }}',
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
                      'Category Added Successfully!',
                      'success'
                      )
                      fetchallCategories();
              }
              $("#add_employee_btn").text('Add Category');
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
      url: '{{ route('editCategory') }}',
              method: 'get',
              data: {
              id: id,
                      _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                console.log(response)
              $("#category_name").val(response.name);
              $("#emp_id").val(response.id);
              }
      });
      });
      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_employee_btn").text('Updating...');
      $.ajax({
      url: '{{ route('updateCategory') }}',
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
                      'Category Updated Successfully!',
                      'success'
                      )
                      fetchallCategories();
              }
              $("#edit_employee_btn").text('Update Category');
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
            url: '{{ route('deleteCategory') }}',
            method: 'delete',
            data: {
                id: id,
                _token: csrf
            },
            success: function(response) {
                console.log(response);
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Category has been deleted.',
                    icon: 'success'
                });
                fetchallCategories();
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log('Error removing category:', xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseText,
                    icon: 'error'
                });
            }
        });
      }
      })
      });
      // fetch all employees ajax request
      fetchallCategories();
      function fetchallCategories() {
      $.ajax({
      url: '{{ route('fetchallCategories') }}',
              method: 'get',
              success: function(response) {
              $("#show_all_employees").html(response);
              $("table").DataTable({
              order: [0, 'desc']
              });
              }
      });
      }

      });
        </script>
    </body>

</html>