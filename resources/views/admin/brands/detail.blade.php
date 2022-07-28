@extends('admin::index')
@section('title', 'ブランド詳細')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/brands/detail.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>ブランド<small>詳細</small></h1>
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
                            <a href="{{ route('admin.brands.editView', ['id' => $brand->id]) }}" class="btn btn-sm btn-primary" title="一覧"><i class="fa fa-edit"></i><span class="hidden-xs">&nbsp;編集</span></a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="username">ブランド名</label>
                        <input type="text" value="{{ $brand->name }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@component('admin.components.deleteModal', [
    'title' => 'ブランド削除',
    'message' => "ブランド「{$brand->name}」を本当に削除しますか？",
    'route' => route('admin.brands.delete', ['id' => $brand->id])
])
@endcomponent
@component('admin.components.errorModal', [
    'message' => "{$brand->name}は削除できません。"
])
@endcomponent
@component('admin.components.successModal')@endcomponent
@endsection
@section('scripts')
<script src="{{ asset('admin/js/common.js') }}"></script>
@endsection
