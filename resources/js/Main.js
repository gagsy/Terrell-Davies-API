import React from "react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import AuthRoute from './AuthRoute'
import routes from "./routes";
import withTracker from "./withTracker";

import Signin from "./views/login/Signin"
import "bootstrap/dist/css/bootstrap.min.css";
import "./styles/shards-dashboards.1.1.0.min.css";
import { transitions, positions, Provider as AlertProvider } from 'react-alert'
import AlertTemplate from 'react-alert-template-basic'

// optional configuration
const options = {
  // you can also just use 'bottom center'
  position: positions.BOTTOM_RIGHT,
  timeout: 5000,
  offset: '30px',
  // you can also just use 'scale'
  transition: transitions.SCALE
}
export default () => (
  <Router basename={process.env.REACT_APP_BASENAME || ""}>
  <div>
  <AlertProvider template={AlertTemplate} {...options}>
  
    <Route exact path='/admin/login' component={Signin} />
   
      {routes.map((route, index) => {
        return (
          
          <AuthRoute
            key={index}
            path={route.path}
            exact={route.exact}
            component={withTracker(props => {
              return (
                <route.layout {...props}>
                  <route.component {...props} />
                </route.layout>
              );
            })}
          />        
        );
      })}
      </AlertProvider>
    </div>
  </Router>
);
