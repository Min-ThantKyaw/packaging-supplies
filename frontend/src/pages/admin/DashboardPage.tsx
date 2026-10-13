import { useTranslation } from 'react-i18next'
import { useAuthStore } from '../../store/auth'

export function DashboardPage() {
  const { t } = useTranslation()
  const user = useAuthStore((state) => state.user)

  return (
    <div className="flex flex-col gap-2">
      <h1 className="text-2xl font-semibold">{t('dashboard.title')}</h1>
      <p className="text-gray-600">{t('dashboard.welcome', { name: user?.name ?? '' })}</p>
    </div>
  )
}
