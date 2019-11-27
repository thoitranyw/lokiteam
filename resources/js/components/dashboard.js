import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Layout, Form, Input, Button, Radio } from 'antd';
import Sidebar from './sidebar'
import axios from 'axios'
import 'antd/dist/antd.css';

const { Header, Content } = Layout;

const DashboardComponent = () => {

    return ( 
        <Layout>
            <Header>Header</Header>
            <Layout>
                <Sidebar />
                <Content style={{ padding: '24px', minHeight: 280 }}>
                    
                </Content>
            </Layout>
        </Layout>
    )
}

if (document.getElementById('loki-container-wrap')) {
    console.log('tests')
    ReactDom.render(<DashboardComponent />, document.getElementById('loki-container-wrap'));
}