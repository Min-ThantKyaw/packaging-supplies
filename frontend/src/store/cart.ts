import { create } from 'zustand'
import type { UnitType } from '../types/api'

export interface CartLine {
  variantId: number
  productName: string
  label?: string
  sku: string
  unitType: UnitType
  unitPrice: number
  quantity: number
}

interface CartState {
  lines: CartLine[]
  add: (line: CartLine) => void
  remove: (variantId: number, unitType: UnitType) => void
  setQuantity: (variantId: number, unitType: UnitType, quantity: number) => void
  clear: () => void
}

const sameLine = (a: CartLine, variantId: number, unitType: UnitType) =>
  a.variantId === variantId && a.unitType === unitType

export const useCartStore = create<CartState>()((set) => ({
  lines: [],
  add: (line) =>
    set((state) => {
      const index = state.lines.findIndex((l) => sameLine(l, line.variantId, line.unitType))
      if (index >= 0) {
        const lines = [...state.lines]
        lines[index] = { ...lines[index], quantity: lines[index].quantity + line.quantity }
        return { lines }
      }
      return { lines: [...state.lines, line] }
    }),
  remove: (variantId, unitType) =>
    set((state) => ({ lines: state.lines.filter((l) => !sameLine(l, variantId, unitType)) })),
  setQuantity: (variantId, unitType, quantity) =>
    set((state) => ({
      lines: state.lines.map((l) =>
        sameLine(l, variantId, unitType) ? { ...l, quantity } : l,
      ),
    })),
  clear: () => set({ lines: [] }),
}))

export function cartTotal(lines: CartLine[]): number {
  return lines.reduce((sum, line) => sum + line.unitPrice * line.quantity, 0)
}
