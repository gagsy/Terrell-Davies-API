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


const FeatureForm = () => (
  <ListGroup flush>
    <ListGroupItem className="p-3">
      <Row>
        <Col>
          <Form>
            <Row form>
              <Col md="12" className="form-group">
                <label htmlFor="title">Name</label>
                <FormInput
                  id="title"
                  type="text"
                  placeholder="Enter feature name"
                  name="title"
                />
                
              </Col>
              <button type="button" class="btn btn-secondary">Add</button>
            </Row>
          </Form>
        </Col>
      </Row>
    </ListGroupItem>
  </ListGroup>
);

export default FeatureForm;
