<div class="modal fade " id="productModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productform" name="productform" class="form-horizontal" enctype="multipart/form-data">
                   {{-- <input type="hidden" name="user_id" id="user_id"> --}}
                   @csrf
                   <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product_id" class="col-sm-2 control-label">UserID</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" placeholder="auto add" value="" maxlength="50"  autocomplete="off" disabled>
                                    @error('product_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="name" class="control-label">Name Product</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter name" value="" maxlength="50" required="" autocomplete="off">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Stock</label>
                                <div class="col-sm-12">
                                    <input type="stock" id="stock" name="stock" required="" placeholder="Enter stock" class="form-control @error('stock') is-invalid @enderror">
                                    @error('stock')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-12">
                                    <input type="text" id="price" name="price" required="" placeholder="Enter price" class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                       </div>
                       <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">Select Image</label>
                                <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                <input class="form-control" type="file" id="image" name="image" onchange="previewImage()">
                              </div>
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
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }
</script>
