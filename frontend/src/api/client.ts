import axios from 'axios'
import type { AxiosError, InternalAxiosRequestConfig } from 'axios'
import { useAuthStore } from '../store/auth'
import type { AuthPayload } from '../types/api'

const baseURL = import.meta.env.VITE_API_URL ?? '/api'

export const api = axios.create({
  baseURL,
  headers: { Accept: 'application/json' },
})

api.interceptors.request.use((config) => {
  const token = useAuthStore.getState().token
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

let refreshing: Promise<string | null> | null = null

async function runRefresh(): Promise<string | null> {
  const { token } = useAuthStore.getState()
  if (!token) {
    return null
  }

  try {
    const { data } = await axios.post<{ data: AuthPayload }>(
      `${baseURL}/auth/refresh`,
      {},
      { headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' } },
    )
    useAuthStore.getState().setSession(data.data)
    return data.data.token
  } catch {
    useAuthStore.getState().clear()
    return null
  }
}

api.interceptors.response.use(
  (response) => response,
  async (error: AxiosError) => {
    const original = error.config as (InternalAxiosRequestConfig & { _retry?: boolean }) | undefined

    if (error.response?.status === 401 && original && !original._retry) {
      original._retry = true
      refreshing ??= runRefresh().finally(() => {
        refreshing = null
      })

      const token = await refreshing
      if (token) {
        original.headers.Authorization = `Bearer ${token}`
        return api(original)
      }
    }

    return Promise.reject(error)
  },
)
