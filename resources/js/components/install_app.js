import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Form, Input, Button, Radio } from 'antd';
import axios from 'axios'
import 'antd/dist/antd.css';

const { Search } = Input;
const InputShopify = () => {
    function installForm(shop) {
        console.log(shop)
        if(shop) {
            axios.post(window.appUrl + '/auth/installHandle', { shop: shop})
            .then(res => {
                console.log('res', res) 
                const { data = null } = res
                console.log('data', data)
                if(data && data.url) {
                    console.log(data.url)
                    document.querySelector('.valid-error-shop').style.display = 'none';
                    window.location.href = data.url 
                }
            } )
            .catch(function(error) {

            })
        } else {
            document.querySelector('.valid-error-shop').style.display = 'block';
        }
        
    }
    return (
        <div>
            <Search
              placeholder="example: lokiapps@myshopify.com"
              enterButton="Login"
              size="large"
              onSearch={value => installForm(value)}
            />
        </div>
    )
}

if (document.getElementById('install__app')) {
    ReactDom.render(<InputShopify />, document.getElementById('install__app'));
}