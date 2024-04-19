<!-- Modal -->
<div class="modal fade" id="quick-add-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Quick Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-add-product">
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="save-new-product">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="pname" class="form-label">Product Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="pname" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="pcode" class="form-label">Product Code</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="pcode" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="micc" class="form-label">Minimum Cart Quantity</label>
                            <div class="position-relative input-icon">
                                <input type="number" step="1" min="1" class="form-control no-arrow" id="micc" name="min_cart_quantity">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-cart"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="mxcc" class="form-label">Maximum Cart Quantity</label>
                            <div class="position-relative input-icon">
                                <input type="number" step="1" min="1" class="form-control no-arrow" id="mxcc" name="max_cart_quantity">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-cart-full"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pmrp" class="form-label">MRP.</label>
                            <div class="position-relative input-icon">
                                <input type="number" step="any" class="form-control no-arrow" id="pmrp" name="maximum_retail_price">
                                <span class="position-absolute top-50 translate-middle-y">₹</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="psp" class="form-label">Selling Price</label>
                            <div class="position-relative input-icon">
                                <input type="number" step="any" class="form-control no-arrow" id="psp" name="retail_price">
                                <span class="position-absolute top-50 translate-middle-y">₹</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
