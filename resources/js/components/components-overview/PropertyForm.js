import React from "react";
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

const PropertyForm = () => (
  <ListGroup flush>
    <ListGroupItem className="p-3">
      <Row>
        <Col>
          <Form>
            <Row form>
              <Col md="6" className="form-group">
                <label htmlFor="title">Location</label>
                <FormInput
                  id="title"
                  type="text"
                  placeholder="Enter property title"
                  name="title"
                />
              </Col>
              <Col md="6">
                <label htmlFor="slug">Meta Description</label>
                <FormInput
                  id="meta"
                  type="text"
                  placeholder="Meta Description"
                />
              </Col>
            </Row>
            <Row form>
            <Col md="3" className="form-group">
            <label htmlFor="bedroom">Bedroom</label>
            <FormInput
            id="bedroom"
            placeholder="Bedroom"
            type="number"
          />
          </Col>
              <Col md="3" className="form-group">
                <label htmlFor="sittingroom">Sitting Room</label>
                <FormInput
                id="sittingroom"
                placeholder="Sitting Room"
                type="number"
              />
              </Col>
              <Col md="3" className="form-group">
                <label htmlFor="bathroom">Bathroom</label>
                <FormInput id="bathroom"
                placeholder="Bathroom"
                type="number"
                />
              </Col>
              <Col md="3" className="form-group">
              <label htmlFor="bathroom">Garage</label>
              <FormInput id="bathroom"
              placeholder="Bathroom"
              type="bathroom"
              type="number"
              />
            </Col>
            </Row>

            <Row form>
            <Col md="4" className="form-group">
            <label htmlFor="type">Type</label>
            <FormSelect id="type">
              <option>Choose...</option>
              <option>...</option>
            </FormSelect>
          </Col>
              <Col md="4" className="form-group">
                <label htmlFor="status">Status</label>
                <FormSelect id="status">
                  <option>Choose...</option>
                  <option>...</option>
                </FormSelect>
              </Col>
              <Col md="4" className="form-group">
                <label htmlFor="price">Price</label>
                <FormInput id="price" />
              </Col>           
            </Row>
            
          </Form>
        </Col>
      </Row>
    </ListGroupItem>
  </ListGroup>
);

export default PropertyForm;
