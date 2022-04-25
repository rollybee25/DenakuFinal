<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="add_store_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Store</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="store_code" placeholder="Store Code..." autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-md-3 col-form-label">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="store_name" placeholder="Store Name..." autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-md-3 col-form-label">Phone</label>
              <div class="col-md-9">
                  <input type="text" class="form-control" id="store_phone" placeholder="Phone..." autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-md-3 col-form-label">Address</label>
              <div class="col-md-9">
                  <textarea class="form-control " autocomplete="off" id="store_address" placeholder="Store Address..." rows="3"></textarea>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn-size update-btn" onclick="submitForm(this);" id="store_save">Save Store</button>
        </div>
      </div>
    </div>
  </div>

  