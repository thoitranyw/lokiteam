@extends('layout.index')

@section('content_container')
    <h1>Hello</h1>
@endsection

@section('footer_container')
    <link href="{{ URL::asset(mix('css/app.min.css')) }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset(mix('js/dashboard.min.js')) }}"></script>
@endsection


