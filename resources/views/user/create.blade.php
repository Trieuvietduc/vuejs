@extends('layout.app')
@section('content')
    <div>
        @if ($errors->any)
            @foreach ($errors->all() as $item)
               <span>{{ $item }}</span>
            @endforeach
        @endif
        <create-user :data="{{ json_encode([
            'urlCheckEmail' => route('user.checkEmail'),
        ]) }}">
        </create-user>
    </div>
@endsection
