<style>
  .image-div {
    display: flex;
    text-align: center;
  }

  .image-div input {
    display: none;
  }

  .image-holder label {
    color: #ccc;
    margin-top: 80px;
    z-index: 9;
    cursor: pointer;
  }

  .image-holder {
    z-index: 10;
    cursor: pointer;
    margin: 0 auto;
    height: 200px;
    width: 200px;
    border: 3px #ccc dashed;
  }

  .image-holder:hover {
    border: 3px skyblue dashed;
  }

</style>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="edit_category_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="" method="post" id="category-form-edit" enctype="multipart/form-data">
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
                      <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name...">
                  </div>
                  <input type="hidden" name="id-to-update" class="id-to-update">
              </div>
              <div class="image-div">
                <input id="picture" 
                onchange="loadFiled(event)" 
                accept="image/*"
                name="picture"
                type="file" />
                <img id="blahed" 
                  width="100" height="100"
                  src="{{asset('images/default/category-default.png')}}" alt="" class="image-holder"
                />
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
            <button type="submit" class="btn-size update-btn" onclick="submitForm(this);" id="product_category_edit">Update Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    var loadFiled = function(event) {
      var reader = new FileReader();
      reader.onload = function(){
        var output = document.getElementById('blahed');
        output.src = reader.result;
      };

      reader.readAsDataURL(event.target.files[0]);
    };
  </script>

  