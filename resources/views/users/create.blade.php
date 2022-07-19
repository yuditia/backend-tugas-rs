<div class="modal fade " id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userform" name="userform" class="form-horizontal" enctype="multipart/form-data">
                   {{-- <input type="hidden" name="user_id" id="user_id"> --}}
                   @csrf
                   <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id" class="col-sm-2 control-label">UserID</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" placeholder="auto add" value="" maxlength="50"  autocomplete="off" disabled>
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter name" value="" maxlength="50" required="" autocomplete="off">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">email</label>
                                <div class="col-sm-12">
                                    <input type="email" id="email" name="email" required="" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" id="password" name="password" required="" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                       </div>
                       <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Select your avatar</label>
                                <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                <input class="form-control" type="file" id="avatar" name="avatar" onchange="previewImage()">
                              </div>
                        </div>
                        <div class="form-group">
                            <select class="form-select" id="isAdmin" name="isAdmin">
                                <option selected>Select Role</option>
                                <option value="0">Not Admin</option>
                                <option value="1">Admin</option>
                              </select>
                        </div>
                    </div>
                       <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>
                               </div>
                        </div>
                       </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}


<script>
    function previewImage(){
        const image = document.querySelector('#avatar');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }
</script>
