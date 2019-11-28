@extends('layout.index')

@section('content_container')
@endsection

@section('footer_container')
    <script type="text/javascript" src="{{ URL::asset(mix('js/dashboard.min.js')) }}"></script>
    @if(session('syncProduct')) 
        <script>
            fetch('/SyncProduct/{{ session("shopId") }}').then(function (res) {
                
            })
        </script>
    @endif
@endsection


