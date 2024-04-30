<!-- Modal -->
<div class="modal fade order-status-change" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="order-status-change">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="order-status-change">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="fdfsas" class="form-label">Order Reference</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fdfsas" name="order_reference"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="gdsdsd" class="form-label">Status</label>
                            <div class="position-relative">
                                <select type="text" class="" id="gdsdsd" name="status_id">
                                    @foreach ($order_statuses as $key => $order_status)
                                        <option value="{{ $order_status->id }}">{{ $order_status->label }}</option>
                                    @endforeach
                                </select>
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
