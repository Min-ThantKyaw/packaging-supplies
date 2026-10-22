const inputClass =
	"w-full rounded-xl border border-gray-200 bg-gray-50/50 py-2.5 pl-10 pr-4 text-sm transition-all focus:border-mg-orange focus:outline-none focus:ring-2 focus:ring-mg-orange/20"

export const LoginForm = () => {
	return (
		<>
			{/* Login Form */}
			<form  className="space-y-4 sm:space-y-5">
				<div>
					<label htmlFor="email" className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-600">Email / Username</label>
					<div className="relative">
						<span className="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
							<i className="fa-regular fa-envelope"></i>
						</span>
						<input
							id="email"
							type="email"
							required
							autoComplete="username"
							name="email"
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
							name="password"
							className={inputClass}
							placeholder="••••••••"
						/>
					</div>
				</div>

				<div className="flex items-center">
					<input
						id="remember"
						type="checkbox"
						className="h-4 w-4 rounded border-gray-300 accent-mg-orange focus:ring-mg-orange"
					/>
					<label htmlFor="remember" className="ml-2 select-none text-xs text-gray-600">Remember this device</label>
				</div>

				<button type="submit" className="group flex w-full items-center justify-center gap-2 rounded-xl bg-mg-orange py-3 font-semibold text-white shadow-md transition-all duration-200 hover:bg-mg-orange-hover hover:shadow-lg">
					<span>Sign In</span>
					<i className="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
				</button>
			</form>
		</>
	)
}