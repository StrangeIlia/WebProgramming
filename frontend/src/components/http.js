import axios from 'axios'

export const HTTP = axios.create({
    baseURL: "http://" + location.hostname + ":10000/api",
    headers: {
        'Content-Type': 'application/json'
    }
});

if(localStorage.token !== undefined)
    HTTP.defaults.headers['Authorization'] = 'Bearer ' + localStorage.token;