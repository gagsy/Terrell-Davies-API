import React from 'react'
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

const AddStatus = () => {
  return (
    <>
    <ListGroup flush>
    <ListGroupItem className="p-3">
      <Row>
        <Col>
          <Form >
            <Row form>
              <Col md="12" className="form-group">
                <label htmlFor="title">Name</label>
                <FormInput
                  type="text"
                  placeholder="Enter status name"
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

export default AddStatus;
