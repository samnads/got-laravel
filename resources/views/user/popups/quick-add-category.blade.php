<!-- Modal -->
<div class="modal fade quick-add-category" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quick-add-category">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="action" value="quick-edit" />
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="fsfrerer" class="form-label">Category Name</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="fsfrerer" name="name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="fhfhs" class="form-label">Description</label>
                            <div class="position-relative">
                                <textarea type="text" class="form-control" id="fhfhs" name="description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="sfssda" class="form-label">Thumbnail Image</label>
                            <input class="form-control" type="file" id="sfssda" name="thumbnail_image" accept="image/*">
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
