@extends('admin.errors.layout')
@section('title', isset(ErrorConsts::TITLE_LIST[$status]) ? ErrorConsts::TITLE_LIST[$status] : ErrorConsts::TITLE_DEFAULT)
@section('content')
<p>
    @if (isset(ErrorConsts::MESSAGE_LIST[$status]))
        {{ ErrorConsts::MESSAGE_LIST[$status] }}
    @else
        {{ ErrorConsts::MESSAGE_DEFAULT }}
    @endif
</p>
<a class="btn btn-primary" href="{{ route('admin.home') }}">ホーム画面</a>
@endsection
