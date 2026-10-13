import { createBrowserRouter, Navigate } from 'react-router-dom'
import { ProtectedRoute } from './components/ProtectedRoute'
import { AdminLayout } from './layouts/AdminLayout'
import { AuthLayout } from './layouts/AuthLayout'
import { DashboardPage } from './pages/admin/DashboardPage'
import { PlaceholderPage } from './pages/admin/PlaceholderPage'
import { LoginPage } from './pages/auth/LoginPage'
import { RegisterPage } from './pages/auth/RegisterPage'

export const router = createBrowserRouter([
  {
    element: <AuthLayout />,
    children: [
      { path: '/login', element: <LoginPage /> },
      { path: '/register', element: <RegisterPage /> },
    ],
  },
  {
    element: <ProtectedRoute />,
    children: [
      {
        element: <AdminLayout />,
        children: [
          { index: true, element: <DashboardPage /> },
          { path: 'products', element: <PlaceholderPage navKey="products" /> },
          { path: 'inventory', element: <PlaceholderPage navKey="inventory" /> },
          { path: 'purchases', element: <PlaceholderPage navKey="purchases" /> },
          { path: 'sales', element: <PlaceholderPage navKey="sales" /> },
          { path: 'customers', element: <PlaceholderPage navKey="customers" /> },
          { path: 'suppliers', element: <PlaceholderPage navKey="suppliers" /> },
          { path: 'delivery-services', element: <PlaceholderPage navKey="deliveryServices" /> },
          { path: 'expenses', element: <PlaceholderPage navKey="expenses" /> },
          { path: 'reports', element: <PlaceholderPage navKey="reports" /> },
        ],
      },
    ],
  },
  { path: '*', element: <Navigate to="/" replace /> },
])
