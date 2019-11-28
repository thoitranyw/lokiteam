document.addEventListener('DOMContentLoaded', function(event) {
    var shopid = document.getElementById('loki-shopid-app').value
    var apiUrl = 'https://e71f720b.ap.ngrok.io/theme/' + shopid;
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

                    setCookie("loki_track_product", JSON.stringify([productId]), 1);
                    fetch(apiUrlView, { 
                        method: 'post', 
                        body: JSON.stringify({product_id: productId})
                    })
                    .then(async res => {
                        var result = await res.json()
                    })
                } else {
                    console.log(loki_track_product)
                    var productIds = JSON.parse(loki_track_product)
                    if(!productIds.includes(productId)) {
                        productIds.push(productId)
                        setCookie("loki_track_product", JSON.stringify(productIds), 1);
                        fetch(apiUrlView, { 
                            method: 'post', 
                            body: JSON.stringify({product_id: productId})
                        })
                        .then(async res => {
                            var result = await res.json()
                        })
                    }
                }
            }
        }
        checkCookie()
    }

    function trackAddToCart() {
        if(document.querySelector('form[action="/cart/add"]')) {
            document.querySelector('form[action="/cart/add"]').addEventListener('submit', function(){
                if(document.getElementById('loki-product-page')) {
                    var productId = document.getElementById('loki-product-page').getAttribute('data-id')
                    console.log('productId', productId)
                    fetch(apiUrlAddToCart, {
                        method: 'post',
                        body: JSON.stringify({product_id: productId})
                    })
                    .then(async res => {
                        var result = await res.json()
                        console.log('result', result)
                    })
                }
            });
        }
        
    }
    function init() {
        if(document.getElementById('loki-shopid-app')) {
  
            fetch(apiUrl, { 
                method: 'get'
            })
            .then(async res => {
                var _result = await res.json()
                const { result: products } = _result
                console.log(products)
                var html = `<h2>Top Sales</h2><ul class="loki-slides">
                        
                        </ul>`
            
                document.querySelector('#loki-product-page').insertAdjacentHTML('beforeend', html)
                var itemHtml = ''
                var hostname = window.location.hostname
                console.log(hostname)
                for(let i = 0; i < 5; i++) {
                    const { product } = products[i]
                    console.log(products[i])
                    itemHtml += '<li><div class="loki-slides-item"><div class="loki-slides-item-img"><a href="https://'+ hostname +'/products/'+ product.handle +'"><img src="'+ product.image +'" /></a></div><h2><a href="https://'+ hostname +'/products/'+ product.handle +'">'+ product.title +'</a></h2></div></li>'
                }
                console.log('itemHtml',itemHtml)
                document.querySelector('.loki-slides').insertAdjacentHTML('beforeend', itemHtml)
                
            })
        }
        
    }
    init()
    trackViewProduct()
    trackAddToCart()
})
