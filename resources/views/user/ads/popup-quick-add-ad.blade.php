<!-- Modal -->
<div class="modal fade" id="quick-add-adv" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Advertisement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-add-adv-form">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="erdz" class="form-label">Ad Name <rf></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="erdz" name="name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="fdga" class="form-label">Requested Vendor</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fdga" name="vendor_id">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="jgw" class="form-label">Banner File (550 x 200px) <rf></label>
                            <div class="position-relative">
                                <input type="file" class="form-control" id="jgw" name="banner_file">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="hetq" class="form-label">Target URL <rf></label>
                            <div class="position-relative">
                                <input type="url" class="form-control" id="hetq" name="banner_url">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="tgerz" class="form-label">Date From <rf></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control no-arrow" id="tgerz" name="from">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="ndfsz" class="form-label">Date To <rf></label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control no-arrow" id="ndfsz" name="to">
                                <span class="position-absolute top-50 translate-middle-y"><i class="lni lni-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
