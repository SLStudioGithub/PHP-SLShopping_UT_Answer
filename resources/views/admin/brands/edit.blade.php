@extends('admin::index')
@section('title', 'ブランド編集')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/brands/edit.css') }}">
@endsection
@section('content')
<section class="content-header">
    <h1>ブランド<small>編集</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">編集</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-sm btn-default" title="一覧"><i class="fa fa-list"></i><span class="hidden-xs">&nbsp;一覧</span></a>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{ route('admin.brands.edit', ['id' => $brand->id]) }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="asterisk">ブランド名</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name"
                                value="{{ old('name', $brand->name) }}" 
                                class="form-control" 
                                placeholder="ブランド名" 
                                required>
                            @error('name')
                                <div class="error-box">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="button" class="btn btn-light" onClick="history.back()">戻る</button>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary">編集</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
