import { useState, type FormEvent } from "react"
import { Link, useNavigate } from "react-router"
import { MgLogo } from "../components"

const inputClass =
	"w-full rounded-xl border border-gray-200 bg-gray-50/50 py-2.5 pl-10 pr-4 text-sm transition-all focus:border-mg-orange focus:outline-none focus:ring-2 focus:ring-mg-orange/20"

export const Login = () => {
	const navigate = useNavigate()
	const [email, setEmail] = useState("admin@mgpackaging.com")
	const [password, setPassword] = useState("password123")
	const [remember, setRemember] = useState(false)

	const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
		event.preventDefault()
		navigate("/seller")
	}

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
						<Link to="/" title="Back to home" className="inline-flex items-center justify-center rounded-2xl bg-mg-dark p-3 shadow-lg">
							<MgLogo className="h-10 w-10 sm:h-12 sm:w-12" />
						</Link>
						<h1 className="mt-4 text-xl font-bold tracking-tight text-mg-dark sm:text-2xl">MG Packaging</h1>
						<p className="mt-1 text-xs text-gray-500 sm:text-sm">Management System Login</p>
					</div>

					{/* Login Form */}
					<form onSubmit={handleSubmit} className="space-y-4 sm:space-y-5">
						<div>
							<label htmlFor="email" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-600">Email / Username</label>
							<div className="relative">
								<span className="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
									<i className="fa-regular fa-envelope"></i>
								</span>
								<input
									id="email"
									type="text"
									required
									autoComplete="username"
									value={email}
									onChange={(event) => setEmail(event.target.value)}
									className={inputClass}
									placeholder="Enter your email"
								/>
							</div>
						</div>

						<div>
							<div className="mb-1.5 flex items-center justify-between">
								<label htmlFor="password" className="block text-xs font-semibold uppercase tracking-wider text-gray-600">Password</label>
								<a href="#" className="text-xs font-medium text-mg-orange hover:underline">Forgot?</a>
							</div>
							<div className="relative">
								<span className="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
									<i className="fa-solid fa-lock"></i>
								</span>
								<input
									id="password"
									type="password"
									required
									autoComplete="current-password"
									value={password}
									onChange={(event) => setPassword(event.target.value)}
									className={inputClass}
									placeholder="••••••••"
								/>
							</div>
						</div>

						<div className="flex items-center">
							<input
								id="remember"
								type="checkbox"
								checked={remember}
								onChange={(event) => setRemember(event.target.checked)}
								className="h-4 w-4 rounded border-gray-300 accent-mg-orange focus:ring-mg-orange"
							/>
							<label htmlFor="remember" className="ml-2 select-none text-xs text-gray-600">Remember this device</label>
						</div>

						<button type="submit" className="group flex w-full items-center justify-center gap-2 rounded-xl bg-mg-orange py-3 font-semibold text-white shadow-md transition-all duration-200 hover:bg-mg-orange-hover hover:shadow-lg">
							<span>Sign In</span>
							<i className="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
						</button>
					</form>

					<div className="mt-6 text-center text-xs text-gray-400">
						&copy; 2026 MG Packaging Co., Ltd. All rights reserved.
					</div>
				</div>
			</div>
		</div>
	)
}
