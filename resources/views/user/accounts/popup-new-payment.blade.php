<!-- Modal -->
<div class="modal fade new-payment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="new-payment">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="gkr" class="form-label">Invoice <rf /></label>
                            <div class="position-relative">
                                <input type="text" class="form-contro" id="gkr" name="invoice_id"
                                    placeholder="Search invoice...">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="lkys" class="form-label">Amount
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="number" step="any" class="form-control" id="lkys" name="amount"
                                    placeholder="0.00" readonly />
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
