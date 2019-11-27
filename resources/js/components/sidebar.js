import React, { useState } from 'react'
import { Link } from "react-router-dom";
import { Layout, Menu, Icon } from 'antd'

const { SubMenu } = Menu;
const { Sider } = Layout;

const Sidebar = () => {
    const [locationPathName, setLocationPathName] = useState({ pathname: window.location.pathname });

    return (
        <Sider width={264} style={{ background: '#fff' }}>
            <Menu
                mode="inline"
                selectedKeys={[locationPathName.pathname]}
                defaultOpenKeys={['sub1']}
                style={{ height: '100%', borderRight: 0 }}
                theme={'light'}
            >
                <Menu.Item key="/" onClick={ () => setLocationPathName({ pathname: '/'}) }>
                    <Icon type="home" />
                    <span className="nav-text">Home</span>
                </Menu.Item>

                <Menu.Item key="7">
                    <Icon type="chrome" />
                    <span className="nav-text">Logout</span>
                </Menu.Item>
            </Menu>

        </Sider>
    );
}

export default Sidebar;