import React, {useState} from "react";
import FeatureDataService from "../../../../Services/featureService"
import { useAlert } from "react-alert";
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

const AddFeature = () => {
  const alert = useAlert();
  const initialFeatureState = {
    id: null,
    featureName: '',
    };
    const [feature, setFeature] = useState(initialFeatureState);
    const [submitted, setSubmitted] = useState(false);

    const handleInputChange = event => {
      const {name, value} = event.target;
      setFeature({...feature, [name]: value});
    };
    const saveFeature = () =>{
      const data = {
        featureName: feature.featureName
      };
      alert.show("Feature added successfully!");

      FeatureDataService.create(data)
      .then(response =>{
        setFeature({
          id: response.data.id,
          featureName: response.data.featureName
        });
        setSubmitted(true);
        console.log(response.data);
      })
      .catch(e =>{
        console.log(e);
      });
    };
    const newFeature = () => {
      setFeature(initialFeatureState);
      setSubmitted(false);
    };

  return (
  <>
  {submitted ? (
    <div>
      <h6>Add Another</h6>
      <button className="btn btn-secondary" onClick={newFeature}>
        Add New
      </button>
    </div>
  ) : (
  <ListGroup flush>
    <ListGroupItem className="p-3">
      <Row>
        <Col>
          <Form>
            <Row form>
              <Col md="12" className="form-group">
                <label htmlFor="title">Name</label>
                <FormInput
                  id="featureName"
                  required
                  type="text"
                  placeholder="Enter property feature name"
                  value={feature.featureName}
                  name="featureName"
                  onChange={handleInputChange}
                />
                
              </Col>
              <div className="text-right">
              <button type="button" onClick={saveFeature} class="btn btn-secondary text-center">Add</button>
              </div>
            </Row>
          </Form> 
        </Col>
      </Row>
    </ListGroupItem>
  </ListGroup>
  )}
  </>
  )};

export default AddFeature;
