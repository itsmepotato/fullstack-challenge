import axios from "axios";
import store from "./store/store";

const http = axios.create({
  baseURL: '/api',
  headers: {
    "Content-type": "application/json"
  }
});

http.interceptors.request.use( (config) => {
  let token = store.getters.token;
  if ( token !== null ) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
})

export default http;
