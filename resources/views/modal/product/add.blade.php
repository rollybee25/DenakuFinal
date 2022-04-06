<!-- Modal -->
<div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
            
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Product Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            
            <div class="modal-body">
                <div class="form-group row">
                    <label for="product_code" class="col-md-3 col-form-label">Code</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="product_code" placeholder="Product Code...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_name" class="col-md-3 col-form-label">Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="product_name" placeholder="Product Name...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_category" class="col-md-3 col-form-label">Category</label>
                    <div class="col-md-9">
                        <select id="product_category" class="form-control">
                            <option selected="">Choose Category...</option>
                            @foreach ($product_category as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_details" class="col-md-3">Details</label>
                    <div class="col-md-9">
                        <textarea class="form-control " id="product_details" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_stocks" class="col-md-3">Stock/s</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="product_stocks" placeholder="Product Stocks...">
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
            <button type="button" class="btn-size update-btn" id="product_save">Save Product</button>
            </div>
        </div>

    </div>
  </div>