import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Layout, Form, Input, Button, Radio, Table, InputNumber, Popconfirm } from 'antd';
import Sidebar from './sidebar'
import axios from 'axios'
import 'antd/dist/antd.css';

const { Header, Content } = Layout;

const data = [];
axios.get(window.appUrl + '/admin-api/products').then(res => {
    console.log('res', res)
})
.catch((error) => {

})
for (let i = 0; i < 10; i++) {
  data.push({
    key: i.toString(),
    product_name: [{ name: 'Product title...', image_url: 'https://ae01.alicdn.com/kf/H091ad26195d2438dba0adbd1ea8d955cm/EAM-Women-Black-Sequins-Split-Big-Size-Dress-New-Round-Neck-Long-Sleeve-Loose-Fit.jpg'}],
    added_product: 52,
    checkouted_product: 150,
    viewed_product: 38
  });
}
const EditableContext = React.createContext();

class EditableCell extends React.Component {
  getInput = () => {
    if (this.props.inputType === 'number') {
      return <InputNumber />;
    }
    return <Input />;
  };

  renderCell = ({ getFieldDecorator }) => {
    const {
      editing,
      dataIndex,
      title,
      inputType,
      record,
      index,
      children,
      ...restProps
    } = this.props;
    return (
      <td {...restProps}>
        {editing ? (
          <Form.Item style={{ margin: 0 }}>
            {getFieldDecorator(dataIndex, {
              rules: [
                {
                  required: true,
                  message: `Please Input ${title}!`,
                },
              ],
              initialValue: record[dataIndex],
            })(this.getInput())}
          </Form.Item>
        ) : (
          children
        )}
      </td>
    );
  };

  render() {
    return <EditableContext.Consumer>{this.renderCell}</EditableContext.Consumer>;
  }
}

class EditableTable extends React.Component {
  constructor(props) {
    super(props);
    this.state = { data, editingKey: '' };
    this.columns = [
      {
        title: 'Product name',
        dataIndex: 'product_name',
        width: '35%',
        editable: false,
        render: product_name => (
            <div>
            {product_name.map(product => {
                    return (
                        <div className={'ant-table-row-cell-product'}>
                            <span className={'ant-table-row-cell-product-img'}>
                                <img src={product.image_url} />
                            </span>
                            <span className={'ant-table-row-cell-product-name'}>
                                {product.name}
                            </span>
                            
                        </div>
                    );
                })
            }
            </div>
            
        )
      },
      {
        title: 'Viewed product',
        dataIndex: 'viewed_product',
        width: '12%',
        editable: false,
      },
      {
        title: 'Added product',
        dataIndex: 'added_product',
        width: '15%',
        editable: false,
      },
      {
        title: 'Checkouted product',
        dataIndex: 'checkouted_product',
        width: '15%',
        editable: false,
      },
      {
        title: 'Position',
        dataIndex: 'position_product',
        width: '10%',
        editable: true,
      },
      {
        title: 'Action',
        dataIndex: 'operation',
        width: '16%',
        render: (text, record) => {
          const { editingKey } = this.state;
          const editable = this.isEditing(record);
          return editable ? (
            <span>
              <EditableContext.Consumer>
                {form => (
                  <a
                    onClick={() => this.save(form, record.key)}
                    style={{ marginRight: 8 }}
                  >
                    Save
                  </a>
                )}
              </EditableContext.Consumer>
              <Popconfirm title="Sure to cancel?" onConfirm={() => this.cancel(record.key)}>
                <a>Cancel</a>
              </Popconfirm>
            </span>
          ) : (
            <a disabled={editingKey !== ''} onClick={() => this.edit(record.key)}>
              Edit
            </a>
          );
        },
      },
    ];
  }

  isEditing = record => record.key === this.state.editingKey;

  cancel = () => {
    this.setState({ editingKey: '' });
  };

  save(form, key) {
      console.log('save')
        form.validateFields((error, row) => {
          if (error) {
            return;
          }
          const newData = [...this.state.data];
          const index = newData.findIndex(item => key === item.key);
          if (index > -1) {
            const item = newData[index];
            newData.splice(index, 1, {
              ...item,
              ...row,
            });
            this.setState({ data: newData, editingKey: '' });
          } else {
            newData.push(row);
            this.setState({ data: newData, editingKey: '' });
            axios.post(window.appUrl + '/sliders/set_position')
            .then(res => {
                console.log('res', res)
            })
            .catch(error => {

            })
          }
        });
  }

    edit(key) {
        console.log('edit')
        this.setState({ editingKey: key });
    }

  render() {
    const components = {
      body: {
        cell: EditableCell,
      },
    };

    const columns = this.columns.map(col => {
      if (!col.editable) {
        return col;
      }
      return {
        ...col,
        onCell: record => ({
          record,
          inputType: col.dataIndex === 'age' ? 'number' : 'text',
          dataIndex: col.dataIndex,
          title: col.title,
          editing: this.isEditing(record),
        }),
      };
    });

    return (
      <EditableContext.Provider value={this.props.form}>
        <Table
          components={components}
          bordered
          dataSource={this.state.data}
          columns={columns}
          rowClassName="editable-row"
          pagination={{
            onChange: this.cancel,
          }}
        />
      </EditableContext.Provider>
    );
  }
}
const EditableFormTable = Form.create()(EditableTable);

const DashboardComponent = () => {
    // state = {
    //     current: 3,
    // };

    // onChange = page => {
    //     console.log(page);
    //     this.setState({
    //       current: page,
    //     });
    // };
    return ( 
        <Layout>
            <Header>Header</Header>
            <Layout>
                <Sidebar />
                <Content style={{ padding: '24px', minHeight: 280 }}>
                    <EditableFormTable />
                    {/* <Pagination current={this.state.current} onChange={this.onChange} total={50} /> */}
                </Content>
            </Layout>
        </Layout>
    )
}

if (document.getElementById('loki-container-wrap')) {
    console.log('tests')
    ReactDom.render(<DashboardComponent />, document.getElementById('loki-container-wrap'));
}

