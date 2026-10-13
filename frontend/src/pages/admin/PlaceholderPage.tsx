import { useTranslation } from 'react-i18next'

export function PlaceholderPage({ navKey }: { navKey: string }) {
  const { t } = useTranslation()

  return (
    <div className="flex flex-col gap-2">
      <h1 className="text-2xl font-semibold">{t(`nav.${navKey}`)}</h1>
      <p className="text-gray-600">{t('common.comingSoon')}</p>
    </div>
  )
}
