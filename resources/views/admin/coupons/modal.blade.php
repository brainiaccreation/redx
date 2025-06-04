<div class="modal fade" id="variantModal" tabindex="-1" aria-labelledby="variantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="variantForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="variantModalLabel">Add Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="editIndex" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="variantName" class="form-control" placeholder="Variant Name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="sku" class="form-control" placeholder="SKU" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <select id="region" class="form-control form-select" required>
                                <option value="">Select Region</option>
                                <option value="MY">Malaysia</option>
                                <option value="SG">Singapore</option>
                                <option value="TH">Thailand</option>
                                <option value="ID">Indonesia</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="denomination" class="form-control" placeholder="Denomination"
                                required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" id="price" class="form-control" name="price" step="0.01"
                                min="0" placeholder="Price (MYR)" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Variant</button>
                </div>
            </form>
        </div>
    </div>
</div>
