@extends('layout.app')
@section('content')
    <div>
        @if ($errors->any)
        @foreach ($errors->all() as $item)
            <li><span style="color: red">{{ $item }}</span></li>
        @endforeach
    @endif
        <create-componnent>
            
        </create-componnent>
    </div>
@endsection
