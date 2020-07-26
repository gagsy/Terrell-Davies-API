import React from "react";
import { Container, Row, Col, Card, CardHeader, CardBody } from "shards-react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import PageTitle from "../components/common/PageTitle";
import SmallButtons from "../components/components-overview/SmallButtons";
import { Button, Modal, ModalBody, ModalHeader } from "shards-react";
import Forms from "../components/components-overview/Forms";
import FormValidation from "../components/components-overview/FormValidation";
import StatusForm from "../components/components-overview/StatusForm";
import axios from 'axios'
class PropertyStatus extends React.Component{

    constructor(props) {
    super(props);
    this.state = {
       open: false,
      statuses: [
        {statusName: ''}
      ]
      };
    this.toggle = this.toggle.bind(this);
    }
    componentDidMount(){
      axios.get('http://127.0.0.1:8000/api/status')
      .then(res => {
        this.setState({
          statuses: res.data
        })
      })
      .catch((error) =>{
        console.log(error);
      })
    }
    DataTable() {
      return this.state.statuses.map(status => {
        return (
          <tr key={status.id}>
              <td></td>
              <td>{status.statusName}</td>
              <td></td>
          </tr>
      );
      });
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
              Add New Status
              </ModalHeader>
              <ModalBody>
            <StatusForm />
            
            </ModalBody>
            </Modal>
            </div>
            <Container fluid className="main-content-container px-4">
            {/* Page Header */}
            <Row noGutters className="page-header py-4">
              <PageTitle sm="4" title="Status" subtitle="Properties" className="text-sm-left" />
            </Row>
        
            {/* Default Light Table */}
            <Row>
              <Col>
                <Card small className="mb-4">
                  <CardHeader className="border-bottom">
                    <h6 className="m-0">Status <button onClick={this.toggle}  type="button" class="btn btn-secondary">Add +</button></h6>
                    
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
                      {this.DataTable()}
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

export default PropertyStatus;
