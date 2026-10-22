import { LoginForm } from "../features/auth"
import { MgLogo } from "../shared/components/MgLogo"

export const Login = () => {

	return (
		<div className="relative flex min-h-screen items-center justify-center overflow-hidden bg-mg-pattern p-4">

			{/* Background decorative glow */}
			<div className="pointer-events-none absolute -left-10 -top-10 h-72 w-72 rounded-full bg-mg-orange/20 blur-3xl sm:h-96 sm:w-96"></div>
			<div className="pointer-events-none absolute -bottom-10 -right-10 h-72 w-72 rounded-full bg-mg-slate/60 blur-3xl sm:h-96 sm:w-96"></div>

			<div className="relative m-4 w-full max-w-md overflow-hidden rounded-2xl border border-white/20 bg-white/95 shadow-2xl backdrop-blur-md">

				{/* Top Branding Accent Bar */}
				<div className="h-2 bg-gradient-to-r from-mg-orange via-orange-400 to-mg-dark"></div>

				<div className="p-6 sm:p-8">

					{/* Logo & Header */}
					<div className="mb-6 text-center sm:mb-8">
						<a title="Back to home" className="inline-flex items-center justify-center rounded-2xl bg-mg-dark p-3 shadow-lg">
							<MgLogo className="h-10 w-10 sm:h-12 sm:w-12" />
						</a>
						<h1 className="mt-4 text-xl font-bold tracking-tight text-mg-dark sm:text-2xl">MG Packaging</h1>
						<p className="mt-1 text-xs text-gray-500 sm:text-sm">Management System Login</p>
					</div>
					
					{/* Login Form Component */}
					<LoginForm />

					<div className="mt-6 text-center text-xs text-gray-400">
						&copy; 2026 MG Packaging Co., Ltd. All rights reserved.
					</div>
				</div>
			</div>
		</div>
	)
}
