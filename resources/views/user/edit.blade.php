@extends('layout.app')
@section('content')
    <div>
        @if ($errors->any)
            @foreach ($errors->all() as $item)
                <li><span>{{ $item }}</span></li>
            @endforeach
        @endif
        <edit-user
            :data="{{ json_encode([
                'urlupdate' => route('user.update', $user->id),
                'urlCheckEmail' => route('user.checkEmail'),
                'user' => $user,
            ]) }}">
        </edit-user>
    </div>
@endsection
