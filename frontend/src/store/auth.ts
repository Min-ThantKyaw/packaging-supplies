import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import type { AuthPayload, User } from '../types/api'

interface AuthState {
  user: User | null
  token: string | null
  expiresAt: string | null
  setSession: (payload: AuthPayload) => void
  setUser: (user: User) => void
  clear: () => void
}

export const useAuthStore = create<AuthState>()(
  persist(
    (set) => ({
      user: null,
      token: null,
      expiresAt: null,
      setSession: (payload) =>
        set({ user: payload.user, token: payload.token, expiresAt: payload.expires_at }),
      setUser: (user) => set({ user }),
      clear: () => set({ user: null, token: null, expiresAt: null }),
    }),
    { name: 'ps-auth' },
  ),
)
