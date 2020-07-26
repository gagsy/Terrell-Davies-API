import React from "react";
import { Container, Row, Col, Card, CardHeader, CardBody } from "shards-react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import PageTitle from "../components/common/PageTitle";
import SmallButtons from "../components/components-overview/SmallButtons";
import { Button, Modal, ModalBody, ModalHeader } from "shards-react";
import Forms from "../components/components-overview/Forms";
import FormValidation from "../components/components-overview/FormValidation";
import PropertyForm from "../components/components-overview/PropertyForm";
class Properties extends React.Component{

    constructor(props) {
    super(props);
    this.state = { open: false };
    this.toggle = this.toggle.bind(this);
    }
    toggle() {
        this.setState({
          open: !this.state.open
        });
      }
      render() {
        const { open } = this.state;
        return (
            <React.Fragment>
            <div>
            <Modal className="modal-lg" open={open} toggle={this.toggle}>
              <ModalHeader>
              Add New Property
              </ModalHeader>
              <ModalBody>
            <PropertyForm />
            </ModalBody>
            </Modal>
            </div>
            <Container fluid className="main-content-container px-4">
            {/* Page Header */}
            <Row noGutters className="page-header py-4">
              <PageTitle sm="4" title="Properties" subtitle="" className="text-sm-left" />
            </Row>
        
            {/* Default Light Table */}
            <Row>
              <Col>
                <Card small className="mb-4">
                  <CardHeader className="border-bottom">
                    <h6 className="m-0">Properties <Link to="/add-property"><button  type="button" class="btn btn-secondary">Add +</button></Link></h6>
                    
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
                            Agent
                          </th>
                          <th scope="col" className="border-0">
                            Type
                          </th>
                          <th scope="col" className="border-0">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>3 bedroom flat</td>
                          <td>Kerry Doe</td>
                          <td>For Rent</td>
                          <td> 
                          <button onClick={this.toggle} type="button" class="btn btn-success">View</button>&nbsp; 
                          <button type="button" class="btn btn-info">Edit</button>&nbsp;
                          <button type="button" class="btn btn-danger">Delete</button>
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
      }

    };

export default Properties;
