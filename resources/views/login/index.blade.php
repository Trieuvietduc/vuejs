@extends('layout.app')
@section('content')
    <div>
        @if (Session::has('error'))
            <div class="alert alert-danger thongbao">
                {{ Session::get('error') }}
            </div>
        @endif
        <login-component :data="{{ json_encode([
            'urlCheckEmail' => route('user.checkEmail'),
        ]) }}">
            <login-component>
    </div>
@endsection
