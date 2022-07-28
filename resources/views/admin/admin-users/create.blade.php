@extends('admin::index')
@section('title', '管理者新規作成')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/admin-users/create.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>管理者<small>新規作成</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">作成</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.adminUsers.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.adminUsers.create') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user-id" class="asterisk">管理者ID</label>
                            <input 
                                type="text" 
                                id="user-id" 
                                name="userId"
                                value="{{ old('userId') }}" 
                                class="form-control" 
                                placeholder="管理者ID" 
                                required>
                            @error('userId')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="user-name" class="asterisk">名前</label>
                            <input 
                                type="text" 
                                id="user-name" 
                                name="userName"
                                value="{{ old('userName') }}" 
                                class="form-control" 
                                placeholder="名前" 
                                required>
                            @error('userName')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="asterisk">パスワード</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                class="form-control" 
                                placeholder="パスワード" 
                                required>
                            @error('password')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="asterisk">パスワード確認用</label>
                            <input 
                                type="password" 
                                id="password-confirm" 
                                name="password_confirmation"
                                class="form-control" 
                                placeholder="パスワード確認用" 
                                required>
                        </div>
                        <div class="form-group">
                            <label class="asterisk">役割</label>
                            <div class="form-check">
                                @foreach ($roles as $role)
                                    <input 
                                        class="form-check-input" 
                                        name="adminUserRoles[]" 
                                        type="checkbox" 
                                        id="{{ "role{$role->id}" }}" 
                                        value="{{ $role->id }}"
                                        {{ is_array(old("adminUserRoles")) && in_array($role->id, old('adminUserRoles')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ "role{$role->id}" }}">{{ $role->name }}</label>
                                @endforeach
                            </div>
                            @error('adminUserRoles')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="asterisk">権限</label>
                            <div class="form-check">
                                @foreach ($permissions as $permission)
                                    <input 
                                        class="form-check-input" 
                                        name="adminUserPermissions[]" 
                                        type="checkbox" 
                                        id="{{ "permission{$permission->id}" }}" 
                                        value="{{ $permission->id }}"
                                        {{ is_array(old("adminUserPermissions")) && in_array($permission->id, old('adminUserPermissions')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ "permission{$permission->id}" }}">{{ $permission->name }}</label>
                                @endforeach
                            </div>
                            @error('adminUserPermissions')
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
