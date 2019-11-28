import React, { useState } from 'react'
import { Link } from "react-router-dom";
import { Layout, Menu, Icon } from 'antd'

const { SubMenu } = Menu;
const { Sider } = Layout;

const Sidebar = () => {
    const [locationPathName, setLocationPathName] = useState({ pathname: window.location.pathname });

    function locationHref(pathname) {
        window.location.href = window.appUrl + pathname
    }
    return (
        <Sider width={264}>
            <Menu
                mode="inline"
                selectedKeys={[locationPathName.pathname]}
                defaultOpenKeys={['home']}
                style={{ height: '100%', borderRight: 0 }}
                theme={'light'}
            >
                <Menu.Item key="/" onClick={ () => locationHref('/') }>
                    <Icon type="home" />
                    <span className="nav-text">Dashboard</span>
                </Menu.Item>

                <Menu.Item key="/products" onClick={ () => locationHref('/products') }>
                    <Icon type="setting" />
                    <span className="nav-text">Products</span>
                </Menu.Item>

                <Menu.Item key="/logout" onClick={ () => locationHref( '/logout') }>
                    <Icon type="logout" />
                    <span className="nav-text">Logout</span>
                </Menu.Item>
            </Menu>

        </Sider>
    );
}

export default Sidebar;