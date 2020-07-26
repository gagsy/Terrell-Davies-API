import React from "react";
import { Container, Row, Col, Card, CardHeader, CardBody } from "shards-react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import PageTitle from "../components/common/PageTitle";
import SmallButtons from "../components/components-overview/SmallButtons";
import { Button, Modal, ModalBody, ModalHeader } from "shards-react";
import Forms from "../components/components-overview/Forms";
import FormValidation from "../components/components-overview/FormValidation";
import TypeForm from "../components/components-overview/TypeForm";

class PropertyTypes extends React.Component{

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
              Add New Property Type
              </ModalHeader>
              <ModalBody>
            <TypeForm />
            
            </ModalBody>
            </Modal>
            </div>
            <Container fluid className="main-content-container px-4">
            {/* Page Header */}
            <Row noGutters className="page-header py-4">
              <PageTitle sm="4" title="Type" subtitle="Properties" className="text-sm-left" />
            </Row>
        
            {/* Default Light Table */}
            <Row>
              <Col>
                <Card small className="mb-4">
                  <CardHeader className="border-bottom">
                    <h6 className="m-0">Type <button onClick={this.toggle}  type="button" class="btn btn-secondary">Add +</button></h6>
                    
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
                          <td>Office</td>
                          <td>21/07/2020</td>
                          <td>  
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

export default PropertyTypes;
