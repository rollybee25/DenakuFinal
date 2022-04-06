<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="edit_category_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Category Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="category_name" placeholder="Category Name...">
                </div>
                <input type="hidden" class="id-to-update">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn-size update-btn" onclick="submitForm(this);" id="product_category_edit">Update Category</button>
        </div>
      </div>
    </div>
  </div>

  