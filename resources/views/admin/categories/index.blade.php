@extends('admin::index')
@section('title', 'カテゴリー一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/categories/index.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>カテゴリー<small>一覧</small></h1>
    @component('admin.components.flashMessage')@endcomponent
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <form id="search-form" method="get" action="{{ route('admin.categories.index') }}">
                        <div class="form-group search-form-box">
                            <label for="id">ID</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="id" 
                                name="id" 
                                placeholder="カテゴリーID"
                                value="{{ isset($_GET['id']) ? $_GET['id'] : '' }}">
                            <div id="id-error" class="error-box"></div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="admin-user-name">名前</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                placeholder="カテゴリー名"
                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.categories.index') }}" role="button">リセット</a>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover grid-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><a href="{{ route('admin.categories.detail', ['id' => $category->id]) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                    <td><a href="{{ route('admin.categories.editView', ['id' => $category->id]) }}" class="btn btn-primary btn-sm">編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $categories->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="module" src="{{ asset('admin/js/categories/index.js') }}"></script>
@endsection
