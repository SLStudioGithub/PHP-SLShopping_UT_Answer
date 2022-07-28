@if (session('message'))
    <div class="alert alert-danger" id="flash-message">
        {{ session('message') }}
    </div>
@endif