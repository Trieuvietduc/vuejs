@extends('layout.app')
@section('content')
    @if ($errors->any)
        @foreach ($errors->all() as $item)
            <li><span>{{ $item }}</span></li>
        @endforeach
    @endif
    <edit-componnent
        :data="{{ json_encode([
            'company' => $company,
            'urlupdate' => route('company.update', $company->id),
        ]) }}">
    </edit-componnent>
@endsection
