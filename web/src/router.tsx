import { createBrowserRouter } from 'react-router'
import { Home, Login, Dashboard, Product } from "./pages"
import { ProtectedRoute } from './components'
import { SellerLayout } from './layouts/SellerLayout'

export const router = createBrowserRouter([
	{
		path: '/',
		children: [
			{ index: true, element: <Home /> },
			{ path: 'login', element: <Login /> },
			{
				element: <ProtectedRoute />,
				children: [
					{
						path: 'seller',
						element: <SellerLayout />,
						children: [
							{ index: true, element: <Dashboard /> },
							{path: 'products', element: <Product /> }
						]
					}
				]
			}
		]
	},
])