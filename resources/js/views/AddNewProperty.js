import React from "react";
import { Container, Row, Col,  Card, CardHeader, ListGroup, ListGroupItem, } from "shards-react";

import PageTitle from "../components/common/PageTitle"; 
import Editor from "../components/add-new-property/Editor";
import SidebarActions from "../components/add-new-property/SidebarActions";
import SidebarCategories from "../components/add-new-property/SidebarCategories";
import CompleteFormExample from "../components/components-overview/CompleteFormExample";
import CustomFileUpload from "../components/components-overview/CustomFileUpload";
import DropdownInputGroups from "../components/components-overview/DropdownInputGroups";
import CustomSelect from "../components/components-overview/CustomSelect";
import PropertyForm from "../components/components-overview/PropertyForm";
const AddNewProperty = () => (
  <Container fluid className="main-content-container px-4 pb-4">
    {/* Page Header */}
    <Row noGutters className="page-header py-4">
      <PageTitle sm="4" title="Add New Property" subtitle="Properties" className="text-sm-left" />
    </Row>

    <Row>
      {/* Editor */}
      <Col lg="9" md="12">
        <Editor />
      </Col>

      {/* Sidebar Widgets */}
      <Col lg="3" md="12">
        <SidebarActions />
        <SidebarCategories />
      </Col>
    </Row>
    <Row>
    <Col lg="9" className="mb-4">
     {/* Complete Form Example */}
     <Card small>
     <CardHeader className="border-bottom">
       <h6 className="m-0">Property Features</h6>
     </CardHeader>
     <PropertyForm />
   </Card>
   </Col>
   <Col lg="3" className="mb-4">
   <Card small>
   {/* Files & Dropdowns */}
   <CardHeader className="border-bottom">
     <h6 className="m-0">Image Upload</h6>
   </CardHeader>

   <ListGroup flush>
     <ListGroupItem className="px-3">
       <strong className="text-muted d-block mb-2">
       Gallery Image Upload
     </strong>
     <CustomFileUpload />
     </ListGroupItem>
     <ListGroupItem className="px-3">
       <strong className="text-muted d-block mb-2">
         Featured Image Upload
       </strong>
       <CustomFileUpload />
     </ListGroupItem>
   </ListGroup>
 </Card>
 </Col>
    </Row>
  </Container>
);

export default AddNewProperty;
