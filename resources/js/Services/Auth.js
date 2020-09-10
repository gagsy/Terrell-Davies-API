import http from '../http-common';

const Auth = {
    login: (data, successCb, failCb) => {
        http .post('/login', data).then(response => {
   
            successCb(response);
   
        }).catch(err => {
   
            failCb(err);
        });
    },
    logout: (successCb, failCb) => {
        http .get('/logout', {headers: {Authorization: 'Bearer ' + localStorage.getItem("user.api_token")}})
            .then(response => {
                localStorage.clear();
   
                successCb(response);
            }).catch(err => {
                failCb(err);
            alert(err.response.data.message);
        });
    },
    checkAuth: (successCb, failCb) => {
        http .get('/check-auth', {headers: {Authorization: 'Bearer ' + localStorage.getItem("user.api_token")}})
            .then(response => {
              successCb(response);
            }).catch(err => {
              failCb(err);
        });
    }
  };
   
  export default Auth;