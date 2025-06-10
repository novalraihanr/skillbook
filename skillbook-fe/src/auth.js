import axiosInstance, { csrf } from './axios.js'
import router from './router/index.js';
import { useUserStore } from '../stores/userStore.js';

export async function check() {
  try {
    await csrf();
    const res = await axiosInstance.get('/api/user');
    return res.data;
  } catch (err) {
    return null;
  }
}

export async function register(formData) {
  try {
    await csrf()
    const response = await axiosInstance.post('/api/register', formData)
    router.push('student')
    return response.data
  } catch (error) {
    console.error('Registration failed', error)
    throw error
  }
}

export async function login(credentials) {
  try {
    await csrf()
    const response = await axiosInstance.post('/login', credentials)
    router.push('student')
    return response.data
  } catch (error) {
    console.log(error)
  }
}

export async function logout() {
  await csrf()
  const response = await axiosInstance.post('/logout')
  const userStore = useUserStore()
  userStore.cleanUser()
  return response.data.message
}
