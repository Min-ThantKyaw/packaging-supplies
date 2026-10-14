import { useEffect, useState } from "react"
import { NavLink, Outlet } from "react-router"
import "../index.css"

const MOBILE_BREAKPOINT = 768

export const SellerLayout = () => {
	const [sidebarOpen, setSidebarOpen] = useState(false)
	const [collapsed, setCollapsed] = useState(false)

	useEffect(() => {
		if (!sidebarOpen) return

		const previousOverflow = document.body.style.overflow
		document.body.style.overflow = "hidden"

		return () => {
			document.body.style.overflow = previousOverflow
		}
	}, [sidebarOpen])

	useEffect(() => {
		const handleResize = () => {
			if (window.innerWidth >= MOBILE_BREAKPOINT) {
				setSidebarOpen(false)
			} else {
				setCollapsed(false)
			}
		}

		window.addEventListener("resize", handleResize)
		return () => window.removeEventListener("resize", handleResize)
	}, [])

	const toggleSidebar = () => {
		if (window.innerWidth < MOBILE_BREAKPOINT) {
			setSidebarOpen((open) => !open)
		} else {
			setCollapsed((value) => !value)
		}
	}

	const textVisibility = `whitespace-nowrap transition-opacity duration-300 ${collapsed ? "opacity-0" : "opacity-100"}`
	const labelVisibility = `overflow-hidden transition-all duration-300 ${collapsed ? "mb-0 max-h-0 opacity-0" : "mb-2 max-h-6 opacity-100"}`

	return (
		<div id="appLayout" className="min-h-screen flex flex-col bg-slate-50">

			{/* NAVBAR */}
			<header className="sticky top-0 z-40 bg-mg-dark text-white shadow-md border-b border-gray-800">
				<div className="flex items-center justify-between px-3 sm:px-6 py-2.5">

					{/* Left Section: Toggle & Logo */}
					<div className="flex items-center gap-2.5 sm:gap-3">
						<button id="sidebarToggle" type="button" aria-label="Toggle navigation" onClick={toggleSidebar} className="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-mg-slate transition-colors focus:outline-none">
							<i className="fa-solid fa-bars text-lg"></i>
						</button>

						<div className="flex items-center gap-2.5">
							<div className="w-8 h-8 rounded-lg bg-mg-orange flex items-center justify-center font-bold text-white text-sm">
								MG
							</div>
							<span className="font-bold tracking-wide text-sm sm:text-base text-white">
								MG <span className="text-mg-orange">Packaging</span>
							</span>
						</div>
					</div>

					{/* Middle Section: Global Search Bar (Hidden on very small screens) */}
					<div className="hidden md:flex items-center flex-1 max-w-md mx-8">
						<div className="relative w-full">
							<span className="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
								<i className="fa-solid fa-magnifying-glass text-xs"></i>
							</span>
							<input type="text" className="w-full pl-9 pr-4 py-1.5 bg-mg-slate/60 text-sm text-gray-200 rounded-xl border border-gray-700/60 focus:outline-none focus:border-mg-orange focus:ring-1 focus:ring-mg-orange placeholder-gray-400" placeholder="Search orders, inventory, clients..." />
						</div>
					</div>

					{/* Right Section: Actions & User Info  */}
					<div className="flex items-center gap-2 sm:gap-3">
						{/* Quick Action Button  */}
						<button className="hidden lg:flex items-center gap-1.5 bg-mg-orange hover:bg-mg-orange-hover text-white text-xs px-3 py-1.5 rounded-lg font-medium transition-all shadow-sm">
							<i className="fa-solid fa-plus"></i>
							<span>New Order</span>
						</button>

						{/* Notifications Button */}
						<button className="relative p-2 text-gray-300 hover:text-white hover:bg-mg-slate rounded-lg transition-colors">
							<i className="fa-regular fa-bell text-base"></i>
							<span className="absolute top-1.5 right-1.5 w-2 h-2 bg-mg-orange rounded-full ring-2 ring-mg-dark"></span>
						</button>

						<div className="h-6 w-px bg-gray-700 mx-0.5 sm:mx-1"></div>

						{/* User Profile Dropdown */}
						<div className="flex items-center gap-2 sm:gap-3 cursor-pointer group">
							<div className="w-8 h-8 rounded-full bg-mg-orange/20 border border-mg-orange text-mg-orange font-semibold flex items-center justify-center text-xs">
								AD
							</div>
							<div className="hidden sm:block text-left">
								<div className="text-xs font-semibold text-gray-200 group-hover:text-mg-orange transition-colors">Admin User</div>
								<div className="text-[10px] text-gray-400">Logistics Mgr</div>
							</div>
							<button title="Logout" className="ml-1 p-1.5 text-gray-400 hover:text-red-400 transition-colors">
								<i className="fa-solid fa-power-off text-sm"></i>
							</button>
						</div>
					</div>

				</div>
			</header>

			<div className="flex flex-1 relative overflow-hidden">

				{/* MOBILE SIDEBAR BACKDROP */}
				<button id="sidebarBackdrop" type="button" aria-label="Close navigation" onClick={() => setSidebarOpen(false)} className={`${sidebarOpen ? "block" : "hidden"} fixed inset-0 bg-black/50 border-0 p-0 z-20 md:hidden transition-opacity`}></button>

				{/* SIDEBAR */}
				<aside id="sidebar" className={`sidebar-transition fixed md:static inset-y-0 left-0 ${sidebarOpen ? "translate-x-0" : "-translate-x-full"} md:translate-x-0 ${collapsed ? "md:w-16" : "md:w-64"} w-64 bg-mg-dark text-gray-300 flex flex-col justify-between border-r border-gray-800 overflow-hidden z-30 shrink-0`}>
					<div className="flex-1 min-h-0 overflow-x-hidden overflow-y-auto p-3 md:pt-9 space-y-6">

						{/* Mobile Sidebar Header Close Button */}
						<div className="flex md:hidden items-center justify-between pb-2 border-b border-gray-800">
							<span className="text-xs font-bold text-gray-400 uppercase tracking-wider">Navigation</span>
							<button type="button" aria-label="Close navigation" onClick={() => setSidebarOpen(false)} className="p-1.5 text-gray-400 hover:text-white">
								<i className="fa-solid fa-xmark text-lg"></i>
							</button>
						</div>

						{/* Menu Category 1: Main */}
						<div>
							<div className={`${labelVisibility} px-3 text-[10px] font-bold tracking-wider text-gray-500 uppercase`}>Main Menu</div>
							<nav className="space-y-1">
								<NavLink to="/seller" end onClick={() => setSidebarOpen(false)} className={({ isActive }) => `nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium ${isActive ? "bg-mg-orange text-white" : "text-gray-400 hover:bg-mg-slate hover:text-white transition-all"}`}>
									<i className="fa-solid fa-chart-pie w-5 text-center"></i>
									<span className={textVisibility}>Dashboard</span>
								</NavLink>
								<NavLink to="/seller/products" onClick={() => setSidebarOpen(false)} className={({ isActive }) => `nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium ${isActive ? "bg-mg-orange text-white" : "text-gray-400 hover:bg-mg-slate hover:text-white transition-all"}`}>
									<i className="fa-solid fa-box-archive w-5 text-center"></i>
									<span className={textVisibility}>Packaging Inventory</span>
								</NavLink>
								<a href="#" className="nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium text-gray-400 hover:bg-mg-slate hover:text-white transition-all">
									<i className="fa-solid fa-truck-ramp-box w-5 text-center"></i>
									<span className={textVisibility}>Orders & Shipments</span>
									<span className={`${textVisibility} ml-auto bg-mg-orange/20 text-mg-orange text-[10px] px-2 py-0.5 rounded-full font-bold`}>12</span>
								</a>
								<a href="#" className="nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium text-gray-400 hover:bg-mg-slate hover:text-white transition-all">
									<i className="fa-solid fa-users w-5 text-center"></i>
									<span className={textVisibility}>Clients & Vendors</span>
								</a>
							</nav>
						</div>

						{/* Menu Category 2: Management */}
						<div>
							<div className={`${labelVisibility} px-3 text-[10px] font-bold tracking-wider text-gray-500 uppercase`}>Management</div>
							<nav className="space-y-1">
								<a href="#" className="nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium text-gray-400 hover:bg-mg-slate hover:text-white transition-all">
									<i className="fa-solid fa-industry w-5 text-center"></i>
									<span className={textVisibility}>Production Line</span>
								</a>
								<a href="#" className="nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium text-gray-400 hover:bg-mg-slate hover:text-white transition-all">
									<i className="fa-solid fa-chart-line w-5 text-center"></i>
									<span className={textVisibility}>Reports & Analytics</span>
								</a>
								<a href="#" className="nav-item flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl font-medium text-gray-400 hover:bg-mg-slate hover:text-white transition-all">
									<i className="fa-solid fa-sliders w-5 text-center"></i>
									<span className={textVisibility}>Settings</span>
								</a>
							</nav>
						</div>

					</div>

					{/* Sidebar Footer Info Box */}
					<div className="p-3 border-t border-gray-800">
						<div id="sidebarFooterCard" className={`bg-mg-slate/40 rounded-xl border border-gray-700/50 flex items-center gap-3 ${collapsed ? "p-2" : "p-3"}`}>
							<div className="w-8 h-8 rounded-lg bg-mg-orange/20 text-mg-orange flex items-center justify-center shrink-0">
								<i className="fa-solid fa-boxes-packing text-sm"></i>
							</div>
							<div className={`${textVisibility} text-xs overflow-hidden`}>
								<p className="font-semibold text-white truncate">Box Stock Alert</p>
								<p className="text-[10px] text-gray-400 truncate">Cardboard Type-B Low</p>
							</div>
						</div>
					</div>

				</aside>
				<main className="min-w-0 flex-1 overflow-y-auto p-3 sm:p-6">
					<Outlet />
				</main>
			</div>
		</div>
	)
}
