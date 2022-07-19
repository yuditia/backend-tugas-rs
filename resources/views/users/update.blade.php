<div class="modal fade " id="updateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="editform" name="editform" class="form-horizontal" method="post">
                   {{-- <input type="hidden" name="user_id" id="user_id"> --}}
                   @method('PUT')
                   <input type="hidden" name="oldImage" id="oldImage">
                   <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id" class="col-sm-2 control-label">UserID</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="update_user_id" name="user_id" placeholder="auto add" value="" maxlength="50"  autocomplete="off" disabled>
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="update_name" name="name" placeholder="Enter name" value="" maxlength="50" required="" autocomplete="off">
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
                                    <input type="email" id="update_email" name="email" required="" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" id="update_password" name="password" required="" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror">
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
                                <img src="" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                <input class="form-control" type="file" id="avatar" name="avatar" onchange="previewImage()">
                              </div>
                        </div>
                        <div class="form-group">
                            <select class="form-select" id="update_isAdmin" name="isAdmin">
                                <option value="">Select Role</option>
                                <option value="0">Not Admin</option>
                                <option value="1">Admin</option>
                              </select>
                        </div>
                    </div>
                       <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="updateBTN" value="create">Save changes
                                </button>
                                <button type="button" class="btn btn-danger" id="cancleBTN">Cancle</button>
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

