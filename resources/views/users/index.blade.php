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
              <h1 class="m-0">Users Data</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
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
                    <a class="btn btn-success mb-3" href="javascript:void(0)" id="createuser"> Create New User</a>
                    <table class="table table-bordered data-table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Avatar</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Avatar</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
      </div>

      {{-- modal --}}
      @include('users.create')
      @include('users.update')

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
        ajax: "{{ route('users') }}",
        columns: [
            {data: 'user_id', name: 'user_id',class:"dt-center"},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data:'avatar', name:'avatar',
            class:"dt-center",
            "render": function (data, type, row, meta) {
                    return '<img src="/storage/' + data + '" alt="' + data + '" class="rounded-circle" height="50px" width="50px"/>';
                }

            },
            {data: 'action', name: 'action',
            orderable: false, searchable: false,
            "width": "20%",
            class: "dt-center"
            },
        ],
        "order": [[ 0, 'desc' ]]
    });

    //button create user

    $('#createuser').on('click',function(){
        $('#saveBtn').val("create-user");
        $('#user_id').val('');
        $('#userform').trigger("reset");
        $('#modelHeading').html("Create New User");
        $('#ajaxModel').modal('show');
    });


    $('#userform').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       var url = "{!! url('/users/store') !!}";
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
               $('#ajaxModel').modal('hide');
               table.draw();
                Swal.fire(
                'Data Saved',
                'User has been created !!',
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
        var user_id = $(this).data('id');
        console.log(user_id);
        // var url = "{{ url('users') }}" +'/' + user_id +'/edit';
        // console.log()
        $.get('users/' + user_id +'/edit', function (data) {
            console.log(data);
          $('#updateHeading').html("Edit User");
          $('#updateBTN').val("edit-user");
          $('#updateModal').modal('show');
          $('#update_user_id').val(data.user_id);
          $('#update_name').val(data.name);
          $('#update_email').val(data.email);
          $('#update_password').val(data.password);
          $('.img-preview').attr('src','/storage/'+ data.avatar);
          $('#oldImage').val(data.avatar);
        //   document.getElementById("update_isAdmin").value = data.isAdmin ? "1" : "0";
        $('#update_isAdmin').val(data.isAdmin ? "1":"0");
      });


    });


    $('#editform').submit(function(e) {
       e.preventDefault();
       const user_id = $('#update_user_id').val();
       var url = "/users/"+ user_id;
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
               $('#updateModal').modal('hide');
               table.draw();
                Swal.fire(
                'Data Saved',
                'User has been created !!',
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

        var user_id = $(this).data('id');
        var name = $('#update_name').val();
        console.log(name);
        var url = "{{ url('users') }}/delete" +'/' + user_id;
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

                    data = { id: user_id, _method: 'delete' };
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
        $('#userform').trigger("reset");
        $('#updateModal').modal('hide');
        $('.img-preview').attr('src','');
    });


    </script>
@endpush
