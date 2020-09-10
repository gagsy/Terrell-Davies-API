import React, {Component} from 'react'
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

import CategoryDataService from "../../../../Services/categoryService";

export default class AddCategory extends Component{

  constructor(props) {
    super(props);
    this.onChangeName = this.onChangeName.bind(this);
    this.saveCategory = this.saveCategory.bind(this);
    this.newCategory = this.newCategory.bind(this);

    this.state = {
      id: null,
      name: "",
      submitted: false
    };
  }

  onChangeName(e) {
    this.setState({
      name: e.target.value
    });
  }


  saveCategory() {
    var data = {
      title: this.state.name,
    };

    CategoryDataService.create(data)
      .then(response => {
        this.setState({
          id: response.data.id,
          name: response.data.name,
          published: response.data.published,

          submitted: true
        });
        console.log(response.data);
      })
      .catch(e => {
        console.log(e);
      });
  }

  newCategory() {
    this.setState({
      id: null,
      name: "",
      submitted: false
    });
  }

  render(){

    return (
      <>
      <ListGroup flush>
      <ListGroupItem className="p-3">
        <Row>
          <Col>
            <Form >
            {this.state.submitted ? (
          <div>
            <h4>You submitted successfully!</h4>
            <button className="btn btn-success" onClick={this.newCategory}>
              Add
            </button>
          </div>
        ) : (
              <Row form>
                <Col md="12" className="form-group">
                  <label htmlFor="title">Name</label>
                  <FormInput
                    type="text"
                    placeholder="Enter category name"
                    name="name"
                    id="name"
                    required
                    value={this.state.name}
                    onChange={this.onChangeName}
                  />
                  
                </Col>status
                <button onClick={this.saveCategory} className="btn btn-secondary">Add</button>
              </Row>
        )}
            </Form>
          </Col>
        </Row>
      </ListGroupItem>
    </ListGroup>
      </>
    )
  }
}

