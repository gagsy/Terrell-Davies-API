import React, {useState, useEffect} from "react";
import { Container, Row, Col, Card, CardHeader, CardBody } from "shards-react";
import PageTitle from "../components/common/PageTitle";
import { Button } from "shards-react";
import {Modal} from "react-bootstrap";
import AddFeature from "../components/components-overview/Forms/PropertyFeature/AddFeature";
import {getFeatures} from "../Services/featureService"
import FeatureDataService from "../Services/featureService"
import axios from 'axios';
import moment from "moment"

function AddFeatureForm(props) {
  return (
    <Modal
      {...props}
      size="md"
      aria-labelledby="contained-modal-title-vcenter"
      centered
    >
      <Modal.Header closeButton>
        <Modal.Title id="contained-modal-title-vcenter">
         Add New Property Feature
        </Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <AddFeature />
      </Modal.Body>
      <Modal.Footer>
        <Button onClick={props.onHide}>Close</Button>
      </Modal.Footer>
    </Modal>
  );
}

const PropertyFeature = () => {
const [modalShow, setModalShow] = useState(false);

const [state, setState] = useState({ features: []})
  
  useEffect(() => {
    getAll()
  },[])
  const getAll = () =>{
    getFeatures().then(data =>{
      setState( (prevState) => ({
        ...prevState,
        features: data.features
      }));
  });
};

        return (
            <React.Fragment>

            <Container fluid className="main-content-container px-4">
            {/* Page Header */}
            <Row noGutters className="page-header py-4">
              <PageTitle sm="4" title="Features" subtitle="Properties" className="text-sm-left" />
            </Row>
        
            {/* Default Light Table */}
            <Row>
              <Col>
                <Card small className="mb-4">
                  <CardHeader className="border-bottom">
                    <h6 className="m-0">Features <button  type="button" onClick={() => setModalShow(true)} className="btn btn-secondary">Add +</button></h6>
                    <AddFeatureForm
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
                            Date Created
                          </th>
                          <th scope="col" className="border-0">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      {state.features.map((feature, index) => (
                        <tr key={index}>
                         <td>{feature.id}</td>
                         <td>{feature.featureName}</td>
                         <td>{moment(feature.created_at).format('MMM-DD-YYYY')}</td>
                         <td>  
                         <button type="button" className="btn btn-info">Edit</button>&nbsp;
                         <button type="button" className="btn btn-danger">Delete</button>
                         </td>
                       </tr>
                     ))}
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

export default PropertyFeature;
