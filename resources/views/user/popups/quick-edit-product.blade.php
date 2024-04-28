<!-- Modal -->
<div class="modal fade quick-edit-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-edit-product" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="quick-edit" />
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="ssdsd" class="form-label">Name <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="ssdsd" name="name"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="dfgfd" class="form-label">Category <rf />
                            </label>
                            <div class="position-relative">
                                <select type="text" class="form-control" id="dfgfd" name="category_id"
                                    autocomplete="off">
                                    <option value=""> -- Select Category --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="dfsteg" class="form-label">Brand <rf />
                            </label>
                            <div class="position-relative">
                                <select type="number" class="form-control no-arrow" id="dfsteg" name="brand_id"
                                    autocomplete="off">
                                    <option value=""> -- Select Brand --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="rysfs" class="form-label">Item Size <rf /></label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="rysfs" name="item_size"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="ghsfre" class="form-label">Unit <rf /></label>
                            <div class="position-relative">
                                <select type="text" class="form-control" id="ghsfre" name="unit_id"
                                    autocomplete="off">
                                    <option value=""> -- Select Unit --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="gdstwe" class="form-label">MRP. <rf />
                            </label>
                            <div class="position-relative">
                                <textarea class="form-control" id="gdstwe" name="maximum_retail_price" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <label for="sdfse" class="form-label">Code <rf />
                            </label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="sdfse" name="code"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="thxse" class="form-label">Thumbnail Image (300 x 300px)
                            </label>
                            <div class="position-relative">
                                <input class="form-control" type="file" id="thxse" name="thumbnail_image" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="deshd" class="form-label">Description
                            </label>
                            <div class="position-relative">
                                <textarea type="number" class="form-control no-arrow" id="deshd" name="description"></textarea>
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
