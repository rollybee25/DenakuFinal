<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="delete_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Product Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">Product Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="product_code" placeholder="Product Code...">
                </div>
                <input type="hidden" class="id-to-update">
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">Product Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="product_name" placeholder="Product Name...">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
            <button type="submit" class="btn-size save-btn" onclick="submitForm(this);" id="product_delete_modal">Delete Product</button>
        </div>
    </div>
</div>
</div>

