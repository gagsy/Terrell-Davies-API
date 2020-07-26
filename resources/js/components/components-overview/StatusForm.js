import React, { Component } from "react";
import SweetAlert from 'react-bootstrap-sweetalert';
import axios from 'axios';
import {
  ListGroup,
  ListGroupItem,
  Row,
  Col,
  Form,
  FormInput,
  FormGroup,
  FormCheckbox,
  FormSelect,
  Button
} from "shards-react";

export default class StatusForm extends Component {
  constructor(props){
    super(props)
    
    //Setting up functions
    this.onChangeStatusName = this.onChangeStatusName.bind(this);
    this.onSubmit = this.onSubmit.bind(this);
    
    //Setting up state
    this.state = {
      statusName: ''
    }
  }
  onChangeStatusName(e){
    this.setState({statusName: e.target.value})
  }
  
  onSubmit(e){
    e.preventDefault()
    const status = {
      statusName: this.state.statusName
    };
    axios.post('http://127.0.0.1:8000/api/create-status', status)
    .then(res => console.log(res.data));

    <SweetAlert
  success
  title="Woot!"
  onConfirm={this.hideAlert}
  onConfirm={(response) => this.onRecieveInput(response)}
>
  I did it!
</SweetAlert>
    this.setState({statusName: ''})
  }
  
  render() {
    return (
      <>
      <ListGroup flush>
      <ListGroupItem className="p-3">
        <Row>
          <Col>
            <Form onSubmit={this.onSubmit}>
              <Row form>
                <Col md="12" className="form-group">
                  <label htmlFor="title">Name</label>
                  <FormInput
                    type="text"
                    placeholder="Enter status name"
                    value={this.state.statusName}
                    onChange={this.onChangeStatusName}
                  />
                  
                </Col>
                <button type="submit" class="btn btn-secondary">Add</button>
              </Row>
            </Form>
          </Col>
        </Row>
      </ListGroupItem>
    </ListGroup>
      </>
    )
  }
}



