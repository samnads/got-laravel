<!-- Modal -->
<div class="modal fade order-details" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details | <span class="o-ref"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Customer</b>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        Name&ensp;&ensp;&ensp;&ensp;:&ensp;&ensp;&ensp;&ensp;<span
                                            class="c-name"></span></li>
                                    <li class="list-group-item">Mobile&ensp;&ensp;&ensp;:&ensp;&ensp;&ensp;&ensp;<span
                                            class="c-mobile"></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <b>Delivery Address</b>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item c-address"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <b>Order Info.</b>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Order Ref.&emsp;&emsp;:&emsp;&emsp;<span
                                            class="o-ref"></span>
                                    </li>
                                    <li class="list-group-item">
                                        Status&emsp;&emsp;&emsp;&ensp;:&emsp;&emsp;<span class="o-status"></span></li>
                                    <li class="list-group-item">
                                        Total Payable :&emsp;&emsp;<span class="o-total_payable fw-bold"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-light">
                                <b>Ordered Products</b>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped table-hover mb-0" id="ordered-products">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sl. No.</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Variant</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-rows">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
