<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="edit_client_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Client Details Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="id-to-update">
          <div class="form-group row">
            <label for="inputPassword" class="col-md-3 col-form-label">Full Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="client_name" placeholder="Client Name..." autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-md-3 col-form-label">Phone</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="client_phone" placeholder="Client Phone..." autocomplete="off">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-md-3 col-form-label">Address</label>
            <div class="col-md-9">
                <textarea class="form-control " autocomplete="off" id="client_address" placeholder="Client Address..." rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn-size update-btn" onclick="submitForm(this);" id="client_edit">Update Client</button>
        </div>
      </div>
    </div>
  </div>

  