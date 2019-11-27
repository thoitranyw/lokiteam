
<div id="install-app-wrap">
    <div class="content-right text-center">
        <div class="form-sign-in">
            <div class="title-form">
                <h2>WELCOME</h2>
                <p>Please enter your Shopify URL</p>
            </div>

            <form id="installation-shop-form" method="post" action="{{ route('apps.installHandle') }}" name="installShopify">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div id="install__app">
                
                </div>
                
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset(mix('js/install_app.min.js')) }}"></script>

