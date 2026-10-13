import { NavLink, Outlet, useNavigate } from 'react-router-dom'
import { useTranslation } from 'react-i18next'
import { LanguageSwitcher } from '../components/LanguageSwitcher'
import { useAuthStore } from '../store/auth'
import { logout as logoutRequest } from '../api/auth'

interface NavItem {
  to: string
  key: string
  end?: boolean
}

const navItems: NavItem[] = [
  { to: '/', key: 'dashboard', end: true },
  { to: '/products', key: 'products' },
  { to: '/inventory', key: 'inventory' },
  { to: '/purchases', key: 'purchases' },
  { to: '/sales', key: 'sales' },
  { to: '/customers', key: 'customers' },
  { to: '/suppliers', key: 'suppliers' },
  { to: '/delivery-services', key: 'deliveryServices' },
  { to: '/expenses', key: 'expenses' },
  { to: '/reports', key: 'reports' },
]

export function AdminLayout() {
  const { t } = useTranslation()
  const navigate = useNavigate()
  const clear = useAuthStore((state) => state.clear)

  async function handleLogout() {
    try {
      await logoutRequest()
    } finally {
      clear()
      navigate('/login', { replace: true })
    }
  }

  return (
    <div className="flex min-h-screen bg-gray-100 text-gray-900">
      <aside className="w-60 shrink-0 border-r border-gray-200 bg-white">
        <div className="px-4 py-5 text-lg font-semibold">{t('common.appName')}</div>
        <nav className="flex flex-col gap-1 px-2 pb-4">
          {navItems.map((item) => (
            <NavLink
              key={item.to}
              to={item.to}
              end={item.end}
              className={({ isActive }) =>
                `rounded-md px-3 py-2 text-sm ${
                  isActive ? 'bg-blue-50 font-medium text-blue-700' : 'text-gray-700 hover:bg-gray-100'
                }`
              }
            >
              {t(`nav.${item.key}`)}
            </NavLink>
          ))}
        </nav>
      </aside>

      <div className="flex flex-1 flex-col">
        <header className="flex items-center justify-end gap-3 border-b border-gray-200 bg-white px-6 py-3">
          <LanguageSwitcher />
          <button
            type="button"
            onClick={handleLogout}
            className="rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50"
          >
            {t('common.logout')}
          </button>
        </header>
        <main className="flex-1 p-6">
          <Outlet />
        </main>
      </div>
    </div>
  )
}
