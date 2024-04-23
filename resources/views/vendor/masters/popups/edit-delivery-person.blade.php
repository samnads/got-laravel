<!-- Modal -->
<div class="modal fade edit-delivery-person" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Edit Delivery Person</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-delivery-person">
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="sdsdst" class="form-label">Name</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="sdsdst" name="name">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-user"></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="sdgfgdsi" class="form-label">Mobile</label>
                            <div class="position-relative input-icon">
                                <input type="number" maxlength="10" minlength="10" class="form-control no-arrow" id="sdgfgdsi" name="mobile_number_1">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-phone"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
