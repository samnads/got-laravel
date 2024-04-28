<!-- Modal -->
<div class="modal fade quick-edit-vendor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-edit-vendor" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="quick-edit" />
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="dfdfdfd" class="form-label">Vendor Name <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="dfdfdfd" name="vendor_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sdcgfs" class="form-label">Owner Name <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="sdcgfs" name="owner_name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="drggdgs" class="form-label">Mobile <rf/></label>
                            <div class="position-relative">
                                <input type="number" class="form-control no-arrow" id="drggdgs" name="mobile_number">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="hjfgd" class="form-label">GST Number <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="hjfgd" name="gst_number">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="dgfddg" class="form-label">Email</label>
                            <div class="position-relative">
                                <input type="email" class="form-control" id="dgfddg" name="email">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sfsfrd" class="form-label">Address <rf/></label>
                            <div class="position-relative">
                                <textarea class="form-control" id="sfsfrd" name="address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="iutgdwr" class="form-label">Login Username <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="iutgdwr" name="username">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="gfsgdxa" class="form-label">Login Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="gfsgdxa" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="yttrd" class="form-label">State</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="yttrd" name="state_id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="hydw" class="form-label">District</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="hydw" name="district_id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="hfdghre" class="form-label">Location <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="hfdghre" name="location_id">
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
