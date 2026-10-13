const currency = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'MMK',
  maximumFractionDigits: 0,
})

export function formatCurrency(value: number): string {
  return currency.format(value)
}

export function formatDate(value: string | Date): string {
  return new Intl.DateTimeFormat('en-GB', { dateStyle: 'medium' }).format(new Date(value))
}
