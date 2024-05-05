<!-- Modal -->
<div class="modal fade quick-add-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-add-product" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="action" value="quick-add" />
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="dfdfdf" class="form-label">Name
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="dfdfdf" name="name"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sdfgdg" class="form-label">Category
                                <rf />
                            </label>
                            <div class="position-relative">
                                <select class="form-control" id="sdfgdg" name="category_id"
                                    autocomplete="off" placeholder="Search category...">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="gdassd" class="form-label">Brand</label>
                            <div class="position-relative">
                                <select class="form-control" id="gdassd" name="brand_id"
                                    autocomplete="off">
                                    <option value="">-- Select Brand --</option>
                                    @foreach ($brands as $key => $brand)
                                        <option value="{{ $brand->value }}">{{ $brand->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="uids" class="form-label">Item Size
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="number" step="1" class="form-control no-arrow" id="uids" name="item_size"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="hsfbzs" class="form-label">Unit
                                <rf />
                            </label>
                            <div class="position-relative">
                                <select type="text" class="form-control" id="hsfbzs" name="unit_id"
                                    autocomplete="off">
                                    <option value=""> -- Select Unit --</option>
                                    @foreach ($units as $key => $unit)
                                        <option value="{{ $unit->value }}">{{ $unit->label }} ({{$unit->code}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="mrpy" class="form-label">MRP.
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input class="form-control" id="mrpy" name="maximum_retail_price"/>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="codegd" class="form-label">Code
                                <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="codegd" name="code"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="thumzsds" class="form-label">Thumbnail Image (300 x 300px)
                            </label>
                            <div class="position-relative">
                                <input class="form-control" type="file" id="thumzsds" name="thumbnail_image" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="desdssw" class="form-label">Description
                            </label>
                            <div class="position-relative">
                                <textarea class="form-control" id="desdssw" name="description"></textarea>
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
