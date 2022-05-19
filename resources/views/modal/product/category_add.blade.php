<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="add_category_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Category</h5>
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
            </div>
            <div class="form-group row">
              <div class="image_div col-md-12 d-flex justify-content-center" style="">
                <div class="" style="border: 2px #ccc dashed; width: 200px; height: 200px">
                    <label for="inputPassword" class="col-md-12 col-form-label" style="text-align: center; color: #ccc; cursor: pointer; margin: 0 auto">Upload Image</label>
                </div>
              </div>
              <div class="" style="display: none">
                  <input type="file" class="form-control" id="image_file" placeholder="Upload Image">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn-size update-btn" onclick="submitForm(this);" id="product_category_save">Save Category</button>
        </div>
      </div>
    </div>
  </div>

  <script>
      
  </script>

  