@extends('admin::index')
@section('title', '商品詳細')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/items/detail.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>商品<small>詳細</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">詳細</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <button class="btn btn-sm btn-danger" id="delete-button"><i class="fa fa-trash"></i><span class="hidden-xs">&nbsp;削除</span></button>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.items.editView', ['id' => $item->id]) }}" class="btn btn-sm btn-primary" title="編集"><i class="fa fa-edit"></i><span class="hidden-xs">&nbsp;編集</span></a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-sm btn-default" title="登録商品一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;登録商品一覧</span></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" id="name" value="{{ $item->name }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">商品説明</label>
                        <textarea 
                            type="text" 
                            id="description" 
                            class="form-control" 
                            readonly 
                            rows="5">{{ $item->description }}</textarea>
                    </div>
                    <div class="form-group split-three-form-box">
                        <label for="price">金額（円）</label>
                        <input type="text" id="price" value="{{ $item->price }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="brand_name">ブランド名</label>
                        <input type="text" id="brand_name" value="{{ $item->brand->name }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="category">カテゴリー名</label>
                        <input type="text" id="category_name" value="{{ $item->category->name }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@component('admin.components.deleteModal', [
    'title' => '商品削除',
    'message' => "商品「{$item->name}」を本当に削除しますか？",
    'route' => route('admin.items.delete', ['id' => $item->id])
])
@endcomponent
@component('admin.components.errorModal', [
        'message' => "{$item->name}は削除できません。"
    ])
@endcomponent
@component('admin.components.successModal')@endcomponent
@endsection
@section('scripts')
<script src="{{ asset('admin/js/common.js') }}"></script>
@endsection
