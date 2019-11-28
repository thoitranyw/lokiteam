import React, { Component } from 'react'
import ReactDom from 'react-dom'
import { Layout, Form, Input, Button, Radio, Table, InputNumber, Popconfirm, Pagination } from 'antd';
import Sidebar from './sidebar'
import axios from 'axios'
import 'antd/dist/antd.css';
import { type } from 'os';

const { Header, Content } = Layout;


const EditableContext = React.createContext();
const baseUrlImage = 'https://ae01.alicdn.com/kf/H091ad26195d2438dba0adbd1ea8d955cm/EAM-Women-Black-Sequins-Split-Big-Size-Dress-New-Round-Neck-Long-Sleeve-Loose-Fit.jpg';

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
    this.onChangePage = this.onChangePage.bind(this)
    this.state = { data: [], editingKey: '', page: 1, total: 1, sort_by: ''};
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
        sorter: true,
        sortDirections: ['descend'],
      },
      {
        title: 'Added product',
        dataIndex: 'added_product',
        width: '15%',
        editable: false,
        sorter: true,
        sortDirections: ['descend'],
      },
      {
        title: 'Checkouted product',
        dataIndex: 'checkouted_product',
        width: '15%',
        editable: false,
        sorter: true,
        sortDirections: ['descend'],
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

  componentWillMount() {
    const urlParams = new URLSearchParams(window.location.search);
    const sortBy = urlParams.get('sortby');
    const page = urlParams.get('page');
    this.setState({page: page ? Number(page) : 1, sort_by: sortBy ? sortBy : ''})
    axios.get(window.appUrl + '/admin-api/products', {
      params: {
        sortby: sortBy ? sortBy : '',
        page: page ? page : 1
      }
    }).then(res => {
        let baseData = res.data.result.data
        let data = [];
        for (let i = 0; i < baseData.length; i++) {
          data.push({
            key: baseData[i].id,
            product_name: [{ name: baseData[i].title, image_url: baseData[i].image ? baseData[i].image : baseUrlImage}],
            added_product: baseData[i].add_to_cart,
            checkouted_product: baseData[i].checkout,
            viewed_product: baseData[i].view,
            position_product: baseData[i].slider ? baseData[i].slider.position : null
          });
        }
        this.setState({data: data, total: res.data.result.last_page})
    })
    .catch((error) => {

    })
      
  }

  isEditing = record => record.key === this.state.editingKey;

  cancel = () => {
    this.setState({ editingKey: '' });
  };

  save(form, key) {
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
            axios.post(window.appUrl + '/admin-api/sliders/set_position', {
              product_id: key,
              position: row.position_product
            })
            .then(res => {
            })
            .catch(error => {

            })
          } else {
            newData.push(row);
            this.setState({ data: newData, editingKey: '' });
            axios.post(window.appUrl + '/admin-api/sliders/set_position', {
                product_id: key,
                position: row.position_product
            })
            .then(res => {
                console.log('res', res)
            })
            .catch(error => {

            })
          }
        });
  }

    edit(key) {
        this.setState({ editingKey: key });
    }

    onChangeTable = async function (pagination, filters, sorter, extra) {
      let sortKey = {
        viewed_product: 'view',
        checkouted_product: 'checkout',
        added_product: 'add_to_cart'
      }
      let sortBy = ''
      if(typeof sortKey[sorter.field] != "undefined") {
        sortBy = sortKey[sorter.field]
      }
      window.location = window.appUrl + '/products?sortby=' + sortBy
    //   let sortBy = ''
    //   if(typeof sortKey[sorter.field] != "undefined") {
    //     sortBy = sortKey[sorter.field]
    //   }
    //   axios.get(window.appUrl + '/admin-api/products', {
    //     params: {
    //       sortby: sortBy
    //     }
    //   }).then(res => {
    //     let baseData = res.data.result.data
    //     let data = [];
       
    //     for (let i = 0; i < baseData.length; i++) {
    //       data.push({
    //         key: baseData[i].id,
    //         product_name: [{ name: baseData[i].title, image_url: baseData[i].image ? baseData[i].image : baseUrlImage}],
    //         added_product: baseData[i].add_to_cart,
    //         checkouted_product: baseData[i].checkout,
    //         viewed_product: baseData[i].view,
    //         position_product: baseData[i].slider ? baseData[i].slider.position : null
    //       });
    //     }
    //     this.setState({data: data})
    // })
    // .catch((error) => {

    // })
  }

  onChangePage(page) {
    window.location = window.appUrl + '/products?sortby=' + this.state.sort_by + '&page=' + page
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
      <div>
        <EditableContext.Provider value={this.props.form}>
          <Table
            components={components}
            bordered
            dataSource={this.state.data}
            columns={columns}
            rowClassName="editable-row"
            onChange={this.onChangeTable}
            pagination={{
              onChange: this.cancel,
            }}
          />
        </EditableContext.Provider>
        <div className={'loki-pagination-wrap'}>
            <Pagination current={this.state.page} onChange={this.onChangePage} total={50} />
        </div>
      </div>
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
            <Header><span className={'logo-loki-app'}>Loki Apps</span></Header>
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

