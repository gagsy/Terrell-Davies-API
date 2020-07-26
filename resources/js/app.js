import React,{Fragment} from 'react';
import ReactDOM from 'react-dom';
import './App.css';
import Main from './Main';
//import "./asset/Bootstrap/css/bootstrap.min.css";

import * as serviceWorker from './serviceWorker';

ReactDOM.render(
  <React.Fragment>
    <Main />
  </React.Fragment>,
  document.getElementById('app')
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
