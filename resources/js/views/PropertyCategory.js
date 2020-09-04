import React, {useState} from "react";
import { Container, Row, Col, Card, CardHeader, CardBody } from "shards-react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import PageTitle from "../components/common/PageTitle";
import { Button } from "shards-react";
import {Modal} from "react-bootstrap";
import AddCategory from "../components/components-overview/Forms/PropertyCategory/AddCategory";
import axios from 'axios'

function AddCategoryForm(props) {
  return (
    <Modal
      {...props}
      size="lg"
      aria-labelledby="contained-modal-title-vcenter"
      centered
    >
      <Modal.Header closeButton>
        <Modal.Title id="contained-modal-title-vcenter">
         Add New Property Category
        </Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <AddCategory/>
      </Modal.Body>
      <Modal.Footer>
        <Button onClick={props.onHide}>Close</Button>
      </Modal.Footer>
    </Modal>
  );
}

const PropertyCategory = ()=> {
  const [modalShow, setModalShow] = useState(false);
  return (
  <React.Fragment>
           
            <Container fluid className="main-content-container px-4">
            {/* Page Header */}
            <Row noGutters className="page-header py-4">
              <PageTitle sm="4" title="Category" subtitle="Properties" className="text-sm-left" />
            </Row>
        
            {/* Default Light Table */}
            <Row>
              <Col>
                <Card small className="mb-4">
                  <CardHeader className="border-bottom">
                    <h6 className="m-0">Category <button onClick={() => setModalShow(true)}  type="button" class="btn btn-secondary">Add +</button></h6>
                    <AddCategoryForm
                    show={modalShow}
                    onHide={() => setModalShow(false)}
                  />
                  </CardHeader>
                  <CardBody className="p-0 pb-3">
                    <table className="table mb-0">
                      <thead className="bg-light">
                        <tr>
                          <th scope="col" className="border-0">
                            #
                          </th>
                          <th scope="col" className="border-0">
                            Title
                          </th>
                          <th scope="col" className="border-0">
                            Created At
                          </th>
                          <th scope="col" className="border-0">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                      <td>1</td>
                      <td>Air Condition</td>
                      <td>21/07/2020</td>
                      <td>  
                      <button type="button" className="btn btn-info">Edit</button>&nbsp;
                      <button type="button" className="btn btn-danger">Delete</button>
                      </td>
                    </tr>
                      </tbody>
                    </table>
                  </CardBody>
                </Card>
              </Col>
            </Row>
          </Container>
          </React.Fragment>
        );
      };


export default PropertyCategory