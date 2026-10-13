import { useTranslation } from 'react-i18next'

export function LanguageSwitcher() {
  const { i18n } = useTranslation()
  const current = i18n.resolvedLanguage ?? 'en'

  return (
    <select
      value={current}
      onChange={(event) => void i18n.changeLanguage(event.target.value)}
      className="rounded-md border border-gray-300 bg-white px-2 py-1 text-sm"
    >
      <option value="en">English</option>
      <option value="mm">မြန်မာ</option>
    </select>
  )
}
