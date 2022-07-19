@extends('layouts.main')
@push('css')

@endpush
@section('container')
@include('sweetalert::alert')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Product Data</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success mb-3" href="javascript:void(0)" id="createproduct"> Create new product</a>
                    <table class="table table-bordered data-table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Product ID</th>
                                <th class="text-center">Image</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Product ID</th>
                                <th class="text-center">Image</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
      </div>

      {{-- modal --}}
      @include('products.create')
      @include('products.update')

@endsection
@push('script')
{{-- <script src="<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>"></script> --}}
{{-- <script src="{{ asset('js/user.js') }}"></script>    --}}
    <script>
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    // data table

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('products') }}",
        columns: [
            {data: 'product_id', name: 'product_id',class:"dt-center"},
            {data:'image', name:'image',
            class:"dt-center",
            "render": function (data, type, row, meta) {
                    return '<img src="/storage/' + data + '" alt="' + data + '" class="rounded-circle" height="50px" width="50px"/>';
                }

            },
            {data: 'name', name: 'name'},
            {data: 'stock', name: 'stock'},
            {data: 'price', name: 'price'},
            {data: 'action', name: 'action',
            orderable: false, searchable: false,
            "width": "20%",
            class: "dt-center"
            },
        ],
        "order": [[ 0, 'desc' ]]
    });

    //button create user

    $('#createproduct').on('click',function(){
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productform').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#productModel').modal('show');
        $('.img-preview').attr('src','');
    });


    $('#productform').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       var url = "{!! url('/products/store') !!}";
       $('#saveBtn').html('Saving...');

       $.ajax({
          type:'POST',
          url: url,
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               $('#saveBtn').html('Save Changes');
               this.reset();
               $('#productModel').modal('hide');
               table.draw();
                Swal.fire(
                'Data Saved',
                'Product has been created !!',
                'success'
                )
             }
           },
           error: function(response){
              console.log(response);
                // $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });

    //button edit data

    $('body').on('click','.editData',function(){
        var product_id = $(this).data('id');
        console.log(product_id);
        // var url = "{{ url('products') }}" +'/' + product_id +'/edit';
        // console.log()
        $.get('products/' + product_id +'/edit', function (data) {
            console.log(data);
          $('#updateHeading').html("Edit Product");
          $('#updateBTN').val("edit-product");
          $('#updateProductModal').modal('show');
          $('#update_product_id').val(data.product_id);
          $('#update_name').val(data.name);
          $('#update_stock').val(data.stock);
          $('#update_price').val(data.price);
          $('.img-preview').attr('src','/storage/'+ data.image);
          $('#oldImage').val(data.image);
      });


    });


    $('#editform').submit(function(e) {
       e.preventDefault();
       const product_id = $('#update_product_id').val();
       var url = "/products/"+ product_id;
       $('#updateBTN').html('Saving...');
       let formData = new FormData(this);

       $.ajax({
          type:'post',
          url: url,
          data:formData,
          _method:'PUT',
           contentType: false,
           processData: false,
           success: (response) => {
             if (response) {
               $('#updateBTN').html('Save Changes');
               this.reset();
               $('#updateProductModal').modal('hide');
               table.draw();
                Swal.fire(
                'Data Saved',
                'Product has been updated !!',
                'success'
                )
             }
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });

    //delete data

    $('body').on('click','.deleteData',function(){

        var product_id = $(this).data('id');
        var name = $('#update_name').val();
        console.log(name);
        var url = "{{ url('products') }}/delete" +'/' + product_id;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,

            }).then((result) => {
            if (result.isConfirmed) {

                    data = { id: product_id, _method: 'delete' };
                    url = url;
                    request = $.post(url, data);

                    swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );
                    table.draw();

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
                )
            }
            });

    });


    $('#cancleBTN').on('click',function(){
        $('#productform').trigger("reset");
        $('#updateProductModal').modal('hide');
        $('.img-preview').attr('src','');
    });


    </script>
@endpush
