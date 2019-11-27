<!DOCTYPE html>
<html>
<head>
    @include('layout.head')
</head>

<body>
    <div class="loki-wrapper">
        <!--Logo - breadcrumb and shop_url-->
        <div id="loki-container-wrap">
            @yield('content_container')
        </div>
    </div>
    
    <link href="{{ URL::asset(mix('css/app.min.css')) }}" rel="stylesheet">
    @yield('footer_container')
</body>
</html>