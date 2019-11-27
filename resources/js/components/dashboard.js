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
<<<<<<< HEAD
                    <div className={'dashboard-wrap'}>
                        <div className={'dashboard-header'}>
                            <p>Product funnel</p>
                        </div>
                        <div className={'dashboard-chart'}>
                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="eye" />
                                </div>
                                <p className={'chart-title'}>Viewed Product</p>
                                <p className={'chart-statistic-number'}>2954</p>
                            </div>

                            <div className={'dashboard-chart-percent__line'}>
                                <p className={'percent-line__text'}>Completion rate</p>
                                <div className={'percent-line__number'}>
=======
                    <div class="dashboard-wrap">
                        <div class="dashboard-header">
                            <p>Product funnel</p>
                        </div>
                        <div class="dashboard-chart">
                            <div class="dashboard-chart-percent__col">
                                <p class="percent-text">100% of all</p>
                                <div class="percent-col">
                                    <Icon type="eye" />
                                </div>
                                <p class="chart-title">Viewed Product</p>
                                <p class="chart-statistic-number">2954</p>
                            </div>

                            <div class="dashboard-chart-percent__line">
                                <p class="percent-line__text">Completion rate</p>
                                <div class="percent-line__number">
>>>>>>> 60baec0c9c0da871d2e5ddc0d7adf34788264111
                                    29%
                                </div>
                            </div>

<<<<<<< HEAD
                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="shopping-cart" />
                                </div>
                                <p className={'chart-title'}>Added product to cart</p>
                                <p className={'chart-statistic-number'}>2954</p>
                            </div>

                            <div className={'dashboard-chart-percent__line'}>
                                <p className={'percent-line__text'}>Completion rate</p>
                                <div className={'percent-line__number'}>
=======
                            <div class="dashboard-chart-percent__col">
                                <p class="percent-text">100% of all</p>
                                <div class="percent-col">
                                    <Icon type="shopping-cart" />
                                </div>
                                <p class="chart-title">Added product to cart</p>
                                <p class="chart-statistic-number">2954</p>
                            </div>

                            <div class="dashboard-chart-percent__line">
                                <p class="percent-line__text">Completion rate</p>
                                <div class="percent-line__number">
>>>>>>> 60baec0c9c0da871d2e5ddc0d7adf34788264111
                                    29%
                                </div>
                            </div>

<<<<<<< HEAD
                            <div className={'dashboard-chart-percent__col'}>
                                <p className={'percent-text'}>100% of all</p>
                                <div className={'percent-col'}>
                                    <Icon type="credit-card" />
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
                            <div className={'dashboard-statistic__time'}>
                                <p className={'dashboard-statistic--title'}>Avg complete time</p>
                                <p className={'dashboard-statistic--number'}>6:20 min</p>
                            </div>
                            <div className={'dashboard-statistic__people'}>
                                <p className={'dashboard-statistic--title'}>Sample size</p>
                                <p className={'dashboard-statistic--number'}>2,954 people</p>
                            </div>
                        </div>
                        <div className={'dashboard-table'}>
=======
                            <div class="dashboard-chart-percent__col">
                                <p class="percent-text">100% of all</p>
                                <div class="percent-col">
                                    <Icon type="credit-card" />
                                </div>
                                <p class="chart-title">Placed an order</p>
                                <p class="chart-statistic-number">2954</p>
                            </div>
                        </div>
                        <div class="dashboard-statistic">
                            <div class="dashboard-statistic__percent">
                                <p class="dashboard-statistic--title">Completion rate</p>
                                <p class="dashboard-statistic--number">15%</p>
                            </div>
                            <div class="dashboard-statistic__time">
                                <p class="dashboard-statistic--title">Avg complete time</p>
                                <p class="dashboard-statistic--number">6:20 min</p>
                            </div>
                            <div class="dashboard-statistic__people">
                                <p class="dashboard-statistic--title">Sample size</p>
                                <p class="dashboard-statistic--number">2,954 people</p>
                            </div>
                        </div>
                        <div class="dashboard-table">
>>>>>>> 60baec0c9c0da871d2e5ddc0d7adf34788264111

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