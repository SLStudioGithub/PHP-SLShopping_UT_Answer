@extends('admin::index')
@section('title', '商品新規作成')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/items/create.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>商品<small>新規作成</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">作成</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('admin.items.create') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="asterisk">商品名</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="form-control"
                                required>
                            @error('name')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="description" class="asterisk">商品説明</label>
                            <textarea 
                                type="text" 
                                id="description" 
                                name="description" 
                                class="form-control" 
                                rows="5"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group split-three-form-box">
                            <label for="price" class="asterisk">金額（円）</label>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                value="{{ old('price') }}" 
                                class="form-control"
                                required>
                            @error('price')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_id" class="asterisk">ブランド</label>
                            <select class="form-control" name="brandId">
                                @foreach ($brands as $brand)
                                    <option 
                                        value="{{ $brand->id }}"
                                        {{ (int)old('brandId') === $brand->id ? 'selected' : '' }}
                                    >{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brandId')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category" class="asterisk">カテゴリー</label>
                            <select class="form-control" name="categoryId">
                                @foreach ($categories as $category)
                                    <option 
                                        value="{{ $category->id }}"
                                        {{ (int)old('categoryId') === $brand->id ? 'selected' : '' }}
                                    >{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="button" class="btn btn-light" onClick="history.back()">戻る</button>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('admin/js/items/create.js') }}"></script>
@endsection
