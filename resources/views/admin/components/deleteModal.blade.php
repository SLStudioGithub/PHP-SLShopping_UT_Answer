<div class="modal fade" id="deleteModal" role="dialog" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ $title }}</h5>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" id="cancel-button" data-bs-dismiss="modal">いいえ</button>
                    <button type="submit" class="btn btn-danger">はい</button>
                </form>
            </div>
        </div>
    </div>
</div>