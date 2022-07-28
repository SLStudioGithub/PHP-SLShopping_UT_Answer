@if (session('notDeletedFlg'))
    <div class="modal fade" id="errorModal" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    {{ $message }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-button" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endif
