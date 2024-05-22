<!-- Modal -->
<div class="modal fade new-invoice" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="new-invoice-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <label for="fgds" class="form-label">Vendor
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <select type="text" class="form-conrol" id="fgds" name="vendor_id"
                                        placeholder="Search vendor...">
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="fdfa" class="form-label">For Month
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="fdfa" name="for_month"
                                        placeholder="Account Month"/>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="dgdc" class="form-label">Due Date
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="dgdc" name="due_date"
                                        placeholder="Due date"/>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="gsay" class="form-label">Amount
                                    <rf />
                                </label>
                                <div class="position-relative">
                                    <input type="text" class="form-control" id="gsay" name="total_payable"
                                        placeholder="0.00" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <b>Orders</b>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-striped table-hover mb-0" id="invoice-line-orders">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl. No.</th>
                                                <th scope="col">Order Ref</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Service Charge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                </fom>
        </div>
    </div>
</div>
