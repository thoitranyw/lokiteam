import React, { Component, useEffect, useState } from 'react'
import ReactDom from 'react-dom'
import { Layout, Card, Col, Row, Icon } from 'antd';
import Sidebar from './sidebar'
import axios from 'axios'
import 'antd/dist/antd.css';

const { Header, Content } = Layout;

const DashboardComponent = () => {
    const [funnel, setFunnel] = useState({
        total_view: 0,
        total_add_to_cart: 0,
        total_checkout: 0
    });

    const [topProduct, setTopProduct] = useState({
        top_view: null,
        top_add_to_cart: null,
        top_checkout: null
    });

    const [max, setMax] = useState(0)

    useEffect(() => {
        axios.get(window.appUrl + '/admin-api/products/funnel').then(function (res) {
            let data = res.data.result[0]
            setFunnel({
                total_view: data.total_view,
                total_add_to_cart: data.total_add_to_cart,
                total_checkout: data.total_checkout,
            })
            setMax(
                Math.max(
                    Number(data.total_view), 
                    Number(data.total_add_to_cart), 
                    Number(data.total_checkout)
                )
            )
        })

        axios.get(window.appUrl + '/admin-api/products/top-product').then(function (res) {
            let data = res.data.result
            setTopProduct({
                top_view: data.top_view,
                top_add_to_cart: data.top_add_to_cart,
                top_checkout: data.top_checkout,
            })
        })
    });

    return ( 
        <Layout>
            <Header><span className={'logo-loki-app'}>Loki Apps</span></Header>
            <Layout>
                <Sidebar />
                <Content style={{ padding: '24px', minHeight: 280 }}>
                    <div className={'loki-container-app'}>
                        <div className={'dashboard-wrap'}>
                            <div className={'dashboard-header'}>
                                <p>Product funnel</p>
                            </div>
                            <div className={'dashboard-chart'}>
                                <div className={'dashboard-chart-percent__col'}>
                                    <p className={'percent-text'}>100% of all</p>
                                    <div className={'percent-col'}>
                                        <Icon type="eye" />
                                        <span style={{height: (funnel.total_view != 0 ? funnel.total_view / max  * 100: 0) + '%'}}></span>
                                    </div>
                                    <p className={'chart-title'}>Viewed Product</p>
                                    <p className={'chart-statistic-number'}>{funnel.total_view}</p>
                                </div>

                                <div className={'dashboard-chart-percent__line'}>
                                    <p className={'percent-line__text'}>Completion rate</p>
                                    <div className={'percent-line__number'}>
                                        {funnel.total_view != 0 ? ((funnel.total_add_to_cart / funnel.total_view * 100) + '%') : '0%'}
                                    </div>
                                </div>

                                <div className={'dashboard-chart-percent__col'}>
                                    <p className={'percent-text'}>100% of all</p>
                                    <div className={'percent-col'}>
                                        <Icon type="shopping-cart" />
                                        <span style={{height: (funnel.total_add_to_cart != 0 ? funnel.total_add_to_cart / max  * 100: 0) + '%'}}></span>
                                    </div>
                                    <p className={'chart-title'}>Added product to cart</p>
                                    <p className={'chart-statistic-number'}>{funnel.total_add_to_cart}</p>
                                </div>

                                <div className={'dashboard-chart-percent__line'}>
                                    <p className={'percent-line__text'}>Completion rate</p>
                                    <div className={'percent-line__number'}>
                                        {funnel.total_add_to_cart != 0 ? ((funnel.total_checkout / funnel.total_add_to_cart * 100) + '%') : '0%'}
                                    </div>
                                </div>

                                <div className={'dashboard-chart-percent__col'}>
                                    <p className={'percent-text'}>100% of all</p>
                                    <div className={'percent-col'}>
                                        <Icon type="credit-card" />
                                        <span style={{height: (funnel.total_checkout != 0 ? funnel.total_checkout / max  * 100: 0) + '%'}}></span>
                                    </div>
                                    <p className={'chart-title'}>Placed an order</p>
                                    <p className={'chart-statistic-number'}>{funnel.total_checkout}</p>
                                </div>
                            </div>
                            {/* <div className={'dashboard-statistic'}>
                                <div className={'dashboard-statistic__percent'}>
                                    <p className={'dashboard-statistic--title'}>Completion rate</p>
                                    <p className={'dashboard-statistic--number'}>15%</p>
                                </div>
                                <div className={'dashboard-statistic__people'}>
                                    <p className={'dashboard-statistic--title'}>Sample size</p>
                                    <p className={'dashboard-statistic--number'}>2,954 people</p>
                                </div>
                            </div> */}
                            <div style={{ background: '#FFF', padding: '30px' }}>
                                <Row gutter={16}>
                                {topProduct.top_view ? (
                                    <Col span={8}>
                                    <Card title="Most view" bordered={true}>
                                    <a 
                                        target={"_blank"} 
                                        href={'https://' + window.shopDomain + '/admin/products/' + topProduct.top_view.id}>{topProduct.top_view.title}</a>
                                    </Card>
                                </Col>
                                ) : ''}
                                
                                {topProduct.top_add_to_cart ? (
                                    <Col span={8}>
                                    <Card title="Most add to cart" bordered={true}>
                                    <a 
                                        target={"_blank"} 
                                        href={'https://' + window.shopDomain + '/admin/products/' + topProduct.top_view.id}>{topProduct.top_add_to_cart.title}</a>
                                    </Card>
                                </Col>
                                ) : ''}
                                {topProduct.top_checkout ? (
                                    <Col span={8}>
                                    <Card title="Most placed an order" bordered={true}>
                                    <a 
                                        target={"_blank"} 
                                        href={'https://' + window.shopDomain + '/admin/products/' + topProduct.top_view.id}>{topProduct.top_checkout.title}</a>
                                    </Card>
                                </Col>
                                ) : ''}
                                </Row>
                            </div>
                            <div className={'dashboard-table'}>

                            </div>
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