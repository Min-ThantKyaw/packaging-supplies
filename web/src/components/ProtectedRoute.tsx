import { Navigate, Outlet } from 'react-router'


export const ProtectedRoute = () => { 
	const isAuthenticated = true;

	if (!isAuthenticated) {
		return <Navigate to="/login" replace />;
	}

	return <Outlet />;
}