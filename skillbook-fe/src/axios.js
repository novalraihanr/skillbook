import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: true,
  headers: {
    'Accept': 'application/json'
  },
  withXSRFToken: true
});

export async function csrf() {
  await axios.get('/sanctum/csrf-cookie')
}

export default axiosInstance;
