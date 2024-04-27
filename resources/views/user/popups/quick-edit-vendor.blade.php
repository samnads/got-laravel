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
                            <label for="fsfrerer" class="form-label">Vendor Name <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Owner Name <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Mobile <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">GST Number<rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Email <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Address <rf/></label>
                            <div class="position-relative">
                                <textarea type="text" class="form-control" id="fsfrerer" name="name"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Login Username <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Login Password <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">State <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">District <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fsfrerer" class="form-label">Location <rf/></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
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
