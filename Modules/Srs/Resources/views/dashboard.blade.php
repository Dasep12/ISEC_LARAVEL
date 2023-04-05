@extends('srs::layouts.template')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('srs.name') !!}
    </p>
@endsection
