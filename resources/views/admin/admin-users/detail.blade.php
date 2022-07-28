@extends('admin::index')
@section('title', '管理者詳細')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/admin-users/detail.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>管理者<small>詳細</small></h1>
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
                            <a href="{{ route('admin.adminUsers.editView', ['id' => $adminUser->id]) }}" class="btn btn-sm btn-primary" title="一覧"><i class="fa fa-edit"></i><span class="hidden-xs">&nbsp;編集</span></a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.adminUsers.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="username">管理者ID</label>
                        <input type="text" value="{{ $adminUser->username }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" value="{{ $adminUser->name }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>役割</label>
                        <div>
                            @foreach ($adminUser->roles as $role)
                                <span class="label label-success">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permission">権限</label>
                        <div>
                            @foreach ($adminUser->permissions as $permission)
                                <span class="label label-success">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@component('admin.components.deleteModal', [
    'title' => '管理者削除',
    'message' => "管理者「{$adminUser->name}」を本当に削除しますか？",
    'route' => route('admin.adminUsers.delete', ['id' => $adminUser->id])
])
@endcomponent
@component('admin.components.successModal')@endcomponent
@endsection
@section('scripts')
<script src="{{ asset('admin/js/common.js') }}"></script>
@endsection
