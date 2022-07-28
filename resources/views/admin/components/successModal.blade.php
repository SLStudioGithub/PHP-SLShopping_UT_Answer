@if (session('completeFlg'))
    <div class="modal fade" id="successModal" role="dialog" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">成功!</h5>
                </div>
                <div class="modal-body">
                    保存が完了しました。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="success-close-button" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
@endif
