import { api } from './client'
import type { ApiEnvelope, AuthPayload, User } from '../types/api'

export interface RegisterInput {
  name: string
  email: string
  password: string
  password_confirmation: string
}

export async function login(email: string, password: string): Promise<AuthPayload> {
  const { data } = await api.post<ApiEnvelope<AuthPayload>>('/auth/login', { email, password })
  return data.data
}

export async function register(input: RegisterInput): Promise<AuthPayload> {
  const { data } = await api.post<ApiEnvelope<AuthPayload>>('/auth/register', input)
  return data.data
}

export async function fetchMe(): Promise<User> {
  const { data } = await api.get<ApiEnvelope<User>>('/auth/me')
  return data.data
}

export async function logout(): Promise<void> {
  await api.post('/auth/logout')
}
