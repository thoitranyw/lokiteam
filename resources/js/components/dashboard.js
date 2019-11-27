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
                                    29%
                                </div>
                            </div>

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
                                    29%
                                </div>
                            </div>

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