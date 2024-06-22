@extends('layouts/contentNavbarLayout')

@section('title', 'Leave')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')


<!-- Success Toast -->
<div class="toast success-toast align-items-center text-white bg-primary border-0 ms-auto" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      {{ session('success') }}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!-- Error Toast -->
<div class="toast error-toast align-items-center text-white bg-danger border-0 ms-auto" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      {{ session('error') }}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<!--TOAST (END)-->


<div class="row gy-4">

  <!-- Data Tables -->
  <div class="col-12">
    <div class="card">
      <div class="table-responsive">


        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $heading }}</h5>
            <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createProduct">Create New Product</button>
          </div>
          <div class="mt-2 d-flex justify-content-end pb-3">
              <input class="form-control" type="text" placeholder="Search"
                aria-label="default input example" style="width: 150px;" id="searchInput">
              <button type="submit" class="btn btn-primary btn-sm" style="margin: 0px 23px;" id="searchButton">Search</button>
          </div>

          <div class="table-responsive text-nowrap">
            <table class="table" id="products-table">
              <thead class="table-light">
                <tr>
                  <th class="text-truncate">ID</th>
                  <th class="text-truncate">Name</th>
                  <th class="text-truncate">Price (RM)</th>
                  <th class="text-truncate">Details</th>
                  <th class="text-truncate">Publish</th>
                  <th class="text-truncate">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($allProduct as $p)
                <tr>
                  <td>{{ $p->id }}</td>
                  <td>{{ $p->name }}</td>
                  <td>{{ $p->price }}</td>
                  <td>{{ $p->detail }}</td>
                  <!--publish-->
                  <td>
                    @if($p->publish == 1)
                        <span class="badge bg-label-primary rounded-pill">Yes</span>
                    @else
                        <span class="badge bg-label-primary rounded-pill">No</span>
                    @endif
                  </td>
                  <!--buttons-->
                  <td>
                      <button type="submit" onclick="loadProductDetails({{ $p->id }})" class="btn btn-info btn-sm" data-bs-toggle="modal">Show</button>
                      <button type="submit" onclick="loadEditProductDetails({{ $p->id }})"class="btn btn-primary btn-sm" data-bs-toggle="modal">Edit</button>
                      <button type="submit" onclick="loadDeleteProductDetails({{ $p->id }})" class="btn btn-sm btn-danger mb-1">Delete</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!--/ Data Tables -->


  <!--CREATE PRODUCT (START)-->
  <div class="modal fade" id="createProduct" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" >Add New Product</h5>
          <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">Back</button>
        </div>

        <div class="modal-body">
          <form method="POST" action="{{ route('create-product') }}">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="fullname">Name</label>
              <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <span id="fullname2" class="input-group-text"><i class="mdi mdi-alphabetical-variant"></i></span>
                  <input type="text" id="name" name="name" class="form-control" placeholder="Name" required/>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="role">Price</label>
              <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <span id="role" class="input-group-text"><i class="mdi mdi-currency-usd"></i></span>
                  <input type="number" id="price" name="price" class="form-control" placeholder="99.90" required step="0.01" min="0" oninput="validateDecimal(this)"/>
                </div>
              </div>
            </div>



            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="reason">Detail</label>
              <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <span id="reason2" class="input-group-text"><i class="mdi mdi-message-outline input-group-prepend"></i></span>
                  <textarea id="detail" name="detail" class="form-control" placeholder="Detail" required rows="3"></textarea>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="startDate">Publish</label>
              <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="options" id="option1-create" value="1" required>
                    <label class="form-check-label" for="option1-create">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="options" id="option2-create" value="0" required>
                    <label class="form-check-label" for="option2-create">No</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row justify-content-end">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--CREATE PRODUCT (END)-->





    <!--SHOW PRODUCT (START)-->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Show Product</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">Back</button>
          </div>

          <div class="modal-body">
            <p><b>Name:</b> <span id="showname" name="showname"></span></p>
            <p><b>Price:</b> RM <span id="showprice" name="showprice"></span></p>
            <p><b>Detail:</b> <span id="showdetail" name="showdetail"></span></p>
            <p><b>Publish:</b> <span id="showpublish" name="showpublish"></span></p>
          </div>
        </div>
      </div>
    </div>
    <!--SHOW PRODUCT (END)-->




    <!--EDIT PRODUCT (START)-->
    <div class="modal fade" id="showEditModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" >Edit Product</h5>
              <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">Back</button>
          </div>

          <div class="modal-body">

            <form id="editProductForm" method="POST" action="">
              @csrf
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="fullname">Name</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="fullname2" class="input-group-text"><i class="mdi mdi-alphabetical-variant"></i></span>
                    <input type="text" id="showeditname" name="name" class="form-control" placeholder="Name" value="" required>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="role">Price</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="role" class="input-group-text"><i class="mdi mdi-currency-usd"></i></span>
                    <input type="number" id="showeditprice" name="price" class="form-control" placeholder="RM 99.99" value="" required step="0.01" min="0" oninput="validateDecimal(this)"/>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="reason">Detail</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                      <span id="reason2" class="input-group-text"><i class="mdi mdi-message-outline input-group-prepend"></i></span>
                      <textarea id="showeditdetail" name="detail" class="form-control" placeholder="Enter Detail" required rows="3"></textarea>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="startDate">Publish</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="options" id="showeditpublishYes" value="1" required>
                      <label class="form-check-label" for="option1-edit">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="options" id="showeditpublishNo" value="0" required>
                      <label class="form-check-label" for="option2-edit">No</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--EDIT PRODUCT (END)-->



    <!--DELETE PRODUCT (START)-->
    <div class="modal fade" id="showDeleteModal" tabindex="-1" aria-labelledby="showLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Delete Product</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">Back</button>
          </div>

          <div class="modal-body">
            <form id="deleteProductForm" action="" method="post" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-danger mb-1">Confirm Deletion</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--DELETE PRODUCT (END)-->







  <style>
    .max-width-td {
        min-width: 200px; /* Set desired maximum width */
        max-width: 300px;
        white-space: normal; /* Allow the text to wrap */
    }

    .input-group-prepend {
      align-self: flex-start; /* Align the icon to the top */
    }
  </style>

</div>



<!--<script src="{{ asset('js/reloadTimer.js') }}"></script>-->
<script src="{{ asset('js/productsearch.js') }}"></script> <!--PRODUCT SEARCH JS-->
<script>

  //TOAST (SCRIPT)-----------------------------------------------------------
  document.addEventListener('DOMContentLoaded', function() {
    // Check for success message
    var successMessage = "{{ session('success') }}";
    if (successMessage) {
      var successToast = document.querySelector('.success-toast');
      var successBootstrapToast = new bootstrap.Toast(successToast);
      successBootstrapToast.show();
    }

    // Check for error message
    var errorMessage = "{{ session('error') }}";
    if (errorMessage) {
      var errorToast = document.querySelector('.error-toast');
      var errorBootstrapToast = new bootstrap.Toast(errorToast);
      errorBootstrapToast.show();
    }

  });
  //TOAST (SCRIPT)--------------------------------------------------------------


  //FOR SEARCHING------------------------------------------------------------------
  window.routes = {
    dashboardProductsAjaxSearch: '{{ route('dashboard.products.ajax-search') }}',
    productsJson: '{{ route('products-json') }}',
  };
  //------------------------------------------------------------------------------


  //LOAD FUNCTIONS---------------------------------------------------------------
  // Add this script to handle the button click and update the modal content
        function loadProductDetails(productId) {
        // Make an AJAX request to retrieve product details based on productId
            $.ajax({
                url: 'product/' + productId,
                type: 'GET',
                success: function(data) {
                    // Update the form fields with the received data
                    $('#showname').text(data.name);
                    $('#showprice').text(data.price);
                    $('#showdetail').text(data.detail);

                    if( data.publish == 1 ){
                      $('#showpublish').text('Yes');
                    } else {
                      $('#showpublish').text('No');
                    }

                    // Show the modal
                    $('#showModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch product details from the API');
                }
            });
        }



        function loadEditProductDetails(productId) {
            // Make an AJAX request to retrieve product details based on productId
            $.ajax({
                url: 'product/' + productId,
                type: 'GET',
                success: function(data) {
                    // Update the form fields with the received data
                    $('#showeditname').val(data.name);
                    $('#showeditprice').val(data.price);
                    $('#showeditdetail').val(data.detail);
                    console.log(data);
                    if( data.publish == 1 ){
                      $('#showeditpublishYes').prop('checked', true);
                    } else {
                      $('#showeditpublishNo').prop('checked', true);
                    }

                    //Update the action form with the productID
                    $('#editProductForm').attr('action', 'edit-product/' + productId);

                    // Show the modal
                    $('#showEditModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch product details from the API');
                }
            });
        }





        function loadDeleteProductDetails(productId) {
            //Update the action form with the productID
            $('#deleteProductForm').attr('action', 'delete-product/' + productId);

            // Show the modal
            $('#showDeleteModal').modal('show');
        }

</script>
@endsection
