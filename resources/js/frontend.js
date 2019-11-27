function init() {
    var shopid = document.getElementById('loki-shopid-app').value
    if(document.getElementById('loki-shopid-app')) {
        console.log('shopid',shopid)
        var apiUrl = 'https://ef58b7cf.ap.ngrok.io/theme/' + shopid;
        fetch(apiUrl, {
            
        }).then(async res => {
            console.log(await res.json())
            var result = await res.json()
            
        })
    }
    
}
init()