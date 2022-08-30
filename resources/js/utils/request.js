import axios from 'axios'
import {Notyf} from 'notyf';
import 'notyf/notyf.min.css';

const service = axios.create({
    //baseURL: 'https://epharm.mauzomkononi.com/api/',
    baseURL: 'http://127.0.0.1:8001/api/',
    timeout: 10000,
});

service.interceptors.response.use(response => {
        return response.data;
    },
    error => {
        let message = error.message;
        if (error.response.data && error.response.data.errors) {
            message = error.response.data.errors;
        } else if (error.response.data && error.response.data.error) {
            message = error.response.data.error;
        }

        const notyf = new Notyf();

        notyf.error(message);

        return Promise.reject(error);
    },
);


export default service
