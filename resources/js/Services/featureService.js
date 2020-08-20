import http from "../http-common";

 const getFeatures = () => {
  return http
  .get("/features")
  .then(res => {
    return res.data
})
};

const get = id => {
  return http.get(`/features/${id}`);
};

const create = data => {
  return http.post("/create-features", data);
};

const update = (id, data) => {
  return http.put(`/features/${id}`, data);
};

const remove = id => {
  return http.delete(`/features/${id}`);
};


export default {
  getFeatures,
  get,
  create,
  update,
  remove
};