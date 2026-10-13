export type UserRole = 'owner'

export type UnitType = 'unit' | 'pack'

export interface User {
  id: number
  name: string
  email: string
  role: UserRole
}

export interface AuthPayload {
  user: User
  token: string
  token_type: string
  expires_at: string
}

export interface ApiEnvelope<T> {
  data: T
  meta?: Record<string, unknown>
}
