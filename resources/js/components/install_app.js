import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Form, Input, Button, Radio } from 'antd';
import 'antd/dist/antd.css';


const { Search } = Input;
const InputShopify = () => {
    return (
        <div>
            <Search
              placeholder="input search text"
              enterButton="Search"
              size="large"
              onSearch={value => console.log(value)}
            />
        </div>
    )
}

if (document.getElementById('install__app')) {
    ReactDom.render(<InputShopify />, document.getElementById('install__app'));
}