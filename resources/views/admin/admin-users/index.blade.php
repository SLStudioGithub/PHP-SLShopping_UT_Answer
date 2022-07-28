@extends('admin::index')
@section('title', '管理者一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/admin-users/index.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>管理者<small>一覧</small></h1>
    @component('admin.components.flashMessage')@endcomponent
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box grid-box">
                <div class="box-header with-border">
                    <form method="get" action="{{ route('admin.adminUsers.index') }}">
                        <div class="form-group search-form-box">
                            <label for="admin-user-id">管理者ID</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="admin-user-id" 
                                name="adminUserId" 
                                placeholder="管理者ID"
                                value="{{ isset($_GET['adminUserId']) ? $_GET['adminUserId'] : '' }}">
                        </div>
                        <div class="form-group search-form-box">
                            <label for="admin-user-name">名前</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="admin-user-name" 
                                name="adminUserName" 
                                placeholder="管理者名"
                                value="{{ isset($_GET['adminUserName']) ? $_GET['adminUserName'] : '' }}">
                        </div>
                        <div class="form-group search-form-box">
                            <label>役割</label>
                            <div class="form-check">
                                @foreach ($roles as $role)
                                    <input 
                                        class="form-check-input" 
                                        name="adminUserRoles[]" 
                                        type="checkbox" 
                                        id="{{ "role{$role->id}" }}" 
                                        value="{{ $role->id }}"
                                        {{ isset($_GET['adminUserRoles']) && in_array($role->id, $_GET['adminUserRoles']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ "role{$role->id}" }}">{{ $role->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group search-form-box">
                            <label>権限</label>
                            <div class="form-check">
                                @foreach ($permissions as $permission)
                                    <input 
                                        class="form-check-input" 
                                        name="adminUserPermissions[]" 
                                        type="checkbox" 
                                        id="{{ "permission{$permission->id}" }}" 
                                        value="{{ $permission->id }}"
                                        {{ isset($_GET['adminUserPermissions']) && in_array($permission->id, $_GET['adminUserPermissions']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ "permission{$permission->id}" }}">{{ $permission->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="search-buttons">
                            <a class="btn btn-default" href="{{ route('admin.adminUsers.index') }}" role="button">リセット</a>
                            <button type="submit" class="btn btn-primary">検索</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover grid-table">
                        <thead>
                            <tr>
                                <th>管理者ID</th>
                                <th>ユーザー名</th>
                                <th>役割</th>
                                <th>権限</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adminUsers as $adminUser)
                                <tr>
                                    <td>{{ $adminUser->username }}</td>
                                    <td>{{ $adminUser->name }}</td>
                                    <td>
                                        @foreach ($adminUser->roles as $role)
                                            <p><span class="label label-success">{{ $role->name }}</span></p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($adminUser->permissions as $permission)
                                            <p><span class="label label-success">{{ $permission->name }}</span></p>
                                        @endforeach
                                    </td>
                                    <td><a href="{{ route('admin.adminUsers.detail', ['id' => $adminUser->id]) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                    <td><a href="{{ route('admin.adminUsers.editView', ['id' => $adminUser->id]) }}" class="btn btn-primary btn-sm">編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-right">
                        {{ $adminUsers->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
