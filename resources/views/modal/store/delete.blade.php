<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="delete_store_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Store Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <input type="hidden" class="id-to-update">
            <label for="inputPassword" class="col-md-3 col-form-label">Store Code</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="store_code" placeholder="Store Code...">
            </div>
          </div>
          <div class="form-group row">
              <label for="inputPassword" class="col-md-3 col-form-label">Store Name</label>
              <div class="col-md-9">
                  <input type="text" class="form-control" id="store_name" placeholder="Store Name...">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn-size save-btn" onclick="submitForm(this);" id="store_delete">Delete Store</button>
        </div>
      </div>
    </div>
  </div>

  