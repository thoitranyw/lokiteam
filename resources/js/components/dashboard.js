import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Layout, Form, Input, Button, Radio, Icon } from 'antd';
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
                    <div className={'dashboard-wrap'}>
                        <div className={'dashboard-header'}>
                            <p>Product funnel</p>
                        </div>
                        <div className={'dashboard-chart'}>
                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="eye" />
                                    <span></span>
                                </div>
                                <p className={'chart-title'}>Viewed Product</p>
                                <p className={'chart-statistic-number'}>2954</p>
                            </div>

                            <div className={'dashboard-chart-percent__line'}>
                                <p className={'percent-line__text'}>Completion rate</p>
                                <div className={'percent-line__number'}>
                                    29%
                                </div>
                            </div>

                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="shopping-cart" />
                                    <span></span>
                                </div>
                                <p className={'chart-title'}>Added product to cart</p>
                                <p className={'chart-statistic-number'}>2954</p>
                            </div>

                            <div className={'dashboard-chart-percent__line'}>
                                <p className={'percent-line__text'}>Completion rate</p>
                                <div className={'percent-line__number'}>
                                    29%
                                </div>
                            </div>

                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="credit-card" />
                                    <span></span>
                                </div>
                                <p className={'chart-title'}>Placed an order</p>
                                <p className={'chart-statistic-number'}>2954</p>
                            </div>
                        </div>
                        <div className={'dashboard-statistic'}>
                            <div className={'dashboard-statistic__percent'}>
                                <p className={'dashboard-statistic--title'}>Completion rate</p>
                                <p className={'dashboard-statistic--number'}>15%</p>
                            </div>
                            <div className={'dashboard-statistic__people'}>
                                <p className={'dashboard-statistic--title'}>Sample size</p>
                                <p className={'dashboard-statistic--number'}>2,954 people</p>
                            </div>
                        </div>
                        <div className={'dashboard-table'}>

                        </div>
                    </div>
                </Content>
            </Layout>
        </Layout>
    )
}

if (document.getElementById('loki-container-wrap')) {
    console.log('tests')
    ReactDom.render(<DashboardComponent />, document.getElementById('loki-container-wrap'));
}