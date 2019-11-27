
<script>
    window.appUrl = "{{ env('APP_URL') }}"
</script>
<div id="install-app-wrap">
    <div class="loki-install">
        <div class="loki-install-box">
            <div class="loki-install-label">LOKI APP</div>
            <video></video>
        </div>
        <div class="loki-install-box">
            <div class="loki-install-welcom">
                <h2>WELCOME</h2>
                <p>Please enter your Shopify URL</p>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div id="install__app">
                    
                </div>
            </div>
        </div>
        
    </div>  
</div>

<link href="{{ URL::asset(mix('css/install_app.min.css')) }}" rel="stylesheet">

<script type="text/javascript" src="{{ URL::asset(mix('js/install_app.min.js')) }}"></script>