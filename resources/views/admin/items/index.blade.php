@extends('admin::index')
@section('title', '登録商品一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/items/index.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>商品<small>一覧</small></h1>
    @component('admin.components.flashMessage')@endcomponent
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <form id="search-form" method="get" action="{{ route('admin.items.index') }}">
                        <div class="form-group search-form-box">
                            <label for="id">ID</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="id" 
                                name="id"
                                value="{{ isset($_GET['id']) ? $_GET['id'] : '' }}"
                                placeholder="商品ID">
                            <div id="id-error" class="error-box"></div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="name">商品名</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name"
                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}"
                                placeholder="商品名">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="low-price">下限金額</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="low-price" 
                                name="lowPrice" 
                                value="{{ isset($_GET['lowPrice']) ? $_GET['lowPrice'] : '' }}"
                                placeholder="0">
                            <div id="low-price-error" class="error-box"></div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="high-price">上限金額</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="high-price" 
                                name="highPrice" 
                                value="{{ isset($_GET['highPrice']) ? $_GET['highPrice'] : '' }}"
                                placeholder="0">
                            <div id="high-price-error" class="error-box"></div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="brand-id">ブランド</label>
                            <select class="form-control" id="brand-id" name="brandId">
                                <option value="">ブランド名</option>
                                @foreach ($brands as $brand)
                                    <option 
                                        value="{{ $brand->id }}" 
                                        {{ isset($_GET['brandId']) && (int) $_GET['brandId'] === $brand->id ? 'selected' : '' }}
                                    >{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <div id="brand-id-error" class="error-box"></div>
                        </div>
                        <div class="form-group search-form-box">
                            <label for="brand-id">ブランド</label>
                            <select class="form-control" id="category-id" name="categoryId">
                                <option value="">カテゴリー名</option>
                                @foreach ($categories as $category)
                                    <option 
                                        value="{{ $category->id }}"
                                        {{ isset($_GET['categoryId']) && (int) $_GET['categoryId'] === $category->id ? 'selected' : '' }}
                                    >{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div id="category-id-error" class="error-box"></div>
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.items.index') }}" role="button">リセット</a>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover grid-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品名</th>
                                <th>金額（円）</th>
                                <th>ブランド名</th>
                                <th>カテゴリー名</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->brand->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td><a href="{{ route('admin.items.detail', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                    <td><a href="{{ route('admin.items.editView', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $items->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script type="module" src="{{ asset('admin/js/items/index.js') }}"></script>
@endsection
