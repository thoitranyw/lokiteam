document.addEventListener('DOMContentLoaded', function(event) {
    var shopid = document.getElementById('loki-shopid-app').value
    var apiUrl = 'https://ef58b7cf.ap.ngrok.io/theme/' + shopid;
    var apiUrlView = apiUrl + '/view';
    var apiUrlAddToCart = apiUrl + '/add_to_cart';


    function trackViewProduct() {
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function checkCookie() {
            console.log('loki-product-page', document.getElementById('loki-product-page'))
            if(document.getElementById('loki-product-page')) {
                var productId = document.getElementById('loki-product-page').getAttribute('data-id')
                console.log('productId', productId)
                var loki_track_product = getCookie("loki_track_product");
                if (loki_track_product == "") {
                    setCookie("loki_track_product", 'viewed', 1);
                    fetch(apiUrlView, { method: 'post', product_id: productId })
                    .then(async res => {
                        console.log('res', res)
                    })
                }
            }
        }
        checkCookie()
    }

    function trackAddToCart() {
        document.querySelector('form[action="/cart/add"]').addEventListener('submit', function(){
            if(document.getElementById('loki-product-page')) {
                var productId = document.getElementById('loki-product-page').getAttribute('data-id')
                console.log('productId', productId)
                fetch(apiUrlAddToCart, {method: 'post', product_id: productId})
                .then(async res => {
                    console.log(await res.json())
                })
            }
        });
    }
    function init() {
        if(document.getElementById('loki-shopid-app')) {
            console.log('shopid',shopid)
            var apiUrl = 'https://ef58b7cf.ap.ngrok.io/theme/' + shopid;
            fetch(apiUrl, {})
            .then(async res => {
                console.log(await res.json())
                var result = await res.json()
                var html = `<ul id="slides">
                            <li class="slide showing">Slide 1</li>
                            <li class="slide">Slide 2</li>
                            <li class="slide">Slide 3</li>
                            <li class="slide">Slide 4</li>
                            <li class="slide">Slide 5</li>
                        </ul>`
                
            })
        }
        
    }
    // init()
    trackViewProduct()
    trackAddToCart()
})
