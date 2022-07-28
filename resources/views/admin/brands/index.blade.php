@extends('admin::index')
@section('title', 'ブランド一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/brands/index.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>ブランド<small>一覧</small></h1>
    @component('admin.components.flashMessage')@endcomponent
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <form id="search-form" method="get" action="{{ route('admin.brands.index') }}">
                        <div class="form-group search-form-box">
                            <label for="id">ID</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="id" 
                                name="id" 
                                placeholder="ブランドID"
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
                                placeholder="ブランド名"
                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.brands.index') }}" role="button">リセット</a>
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
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td><a href="{{ route('admin.brands.detail', ['id' => $brand->id]) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                    <td><a href="{{ route('admin.brands.editView', ['id' => $brand->id]) }}" class="btn btn-primary btn-sm">編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $brands->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="module" src="{{ asset('admin/js/brands/index.js') }}"></script>
@endsection
