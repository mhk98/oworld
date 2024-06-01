
    <!------ Start Delete Modal ------->
    <div class="delete-modal modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">

                    <p class="fs-5 fw-semibold mb-3">Are you sure you want to delete this item?</p>

                    <form id="deleteForm" action="{{ route('merchant.deleteContent') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="content_type" id="content_type">
                        <input type="hidden" name="content_id" id="content_id">

                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!------- End Delete Modal -------->