import { Link } from "react-router"
import { MgLogo } from "../shared/components"

const navLinks = [
	{ label: "Products", href: "#products" },
	{ label: "Why Us", href: "#why-us" },
	{ label: "Contact", href: "#contact" },
]

const stats = [
	{ value: "500+", label: "Business clients" },
	{ value: "12,000+", label: "Boxes shipped daily" },
	{ value: "15 yrs", label: "Industry experience" },
	{ value: "24/7", label: "Order support" },
]

const products = [
	{ icon: "fa-boxes-stacked", name: "Corrugated Boxes", description: "Single, double and triple wall cartons in every standard size." },
	{ icon: "fa-print", name: "Custom Printed Boxes", description: "Die-cut and flexo printed packaging that carries your brand." },
	{ icon: "fa-tape", name: "Tapes & Adhesives", description: "Clear, kraft and printed carton sealing tapes in bulk rolls." },
	{ icon: "fa-layer-group", name: "Bubble Wrap & Foam", description: "Air bubble rolls, EPE foam and protective wrapping." },
	{ icon: "fa-scroll", name: "Kraft Paper & Void Fill", description: "Eco kraft paper, honeycomb wrap and sustainable fillers." },
	{ icon: "fa-tags", name: "Strapping & Labels", description: "PP strapping, hand tools and thermal shipping labels." },
]

const features = [
	{ icon: "fa-truck-fast", title: "Same-day dispatch", description: "Orders confirmed before 2 PM leave our warehouse the same day." },
	{ icon: "fa-medal", title: "Quality guaranteed", description: "Every batch is load tested so your goods arrive undamaged." },
	{ icon: "fa-headset", title: "Dedicated support", description: "A named account manager for bulk and contract customers." },
	{ icon: "fa-recycle", title: "Eco-friendly options", description: "Recycled and biodegradable packaging available on request." },
]

export const Home = () => {
	return (
		<div className="min-h-screen bg-slate-100 font-sans text-gray-800">

			{/* NAVBAR */}
			<header className="sticky top-0 z-40 border-b border-gray-800 bg-mg-dark text-white shadow-md">
				<div className="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
					<Link to="/" className="flex items-center gap-2.5">
						<div className="flex h-8 w-8 items-center justify-center rounded-lg bg-mg-orange text-sm font-bold text-white">MG</div>
						<span className="text-sm font-bold tracking-wide sm:text-base">
							MG <span className="text-mg-orange">Packaging</span>
						</span>
					</Link>

					<nav className="hidden items-center gap-8 md:flex">
						{navLinks.map((link) => (
							<a key={link.href} href={link.href} className="text-sm font-medium text-gray-300 transition-colors hover:text-mg-orange">
								{link.label}
							</a>
						))}
					</nav>

					<Link to="/login" className="inline-flex items-center gap-1.5 rounded-lg bg-mg-orange px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-mg-orange-hover sm:text-sm">
						<i className="fa-solid fa-right-to-bracket"></i>
						<span>Staff Login</span>
					</Link>
				</div>
			</header>

			{/* HERO */}
			<section className="bg-mg-pattern">
				<div className="mx-auto flex max-w-4xl flex-col items-center px-4 py-16 text-center sm:px-6 lg:py-24">
					<div className="flex h-20 w-20 items-center justify-center rounded-2xl bg-white shadow-2xl shadow-black/40">
						<MgLogo className="h-14 w-14" />
					</div>

					<span className="mt-6 inline-flex items-center gap-2 rounded-full border border-mg-orange/30 bg-mg-orange/10 px-3 py-1 text-xs font-semibold text-mg-orange">
						<i className="fa-solid fa-box-open"></i>
						Packaging partner for growing businesses
					</span>

					<h1 className="mt-5 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
						Everything you need to <span className="text-mg-orange">pack, protect and ship</span> your products.
					</h1>

					<p className="mt-4 max-w-2xl text-sm text-gray-300 sm:text-base">
						From corrugated cartons and tapes to custom printed boxes — MG Packaging supplies, delivers and manages stock for businesses across Myanmar.
					</p>

					<div className="mt-8 flex flex-wrap items-center justify-center gap-3">
						<a href="#products" className="inline-flex items-center gap-2 rounded-xl bg-mg-orange px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-mg-orange/25 transition-colors hover:bg-mg-orange-hover">
							Browse Products
							<i className="fa-solid fa-arrow-right text-xs"></i>
						</a>
						<Link to="/login" className="inline-flex items-center gap-2 rounded-xl border border-gray-700 px-5 py-3 text-sm font-semibold text-gray-200 transition-colors hover:border-mg-orange hover:text-mg-orange">
							Staff Portal
						</Link>
					</div>
				</div>
			</section>

			{/* STATS */}
			<section className="border-b border-gray-200 bg-white">
				<div className="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-10 sm:px-6 lg:grid-cols-4">
					{stats.map((stat) => (
						<div key={stat.label} className="text-center">
							<p className="text-2xl font-bold text-mg-dark sm:text-3xl">{stat.value}</p>
							<p className="mt-1 text-xs font-medium uppercase tracking-wider text-gray-500">{stat.label}</p>
						</div>
					))}
				</div>
			</section>

			{/* PRODUCTS */}
			<section id="products" className="py-16 sm:py-20">
				<div className="mx-auto max-w-7xl px-4 sm:px-6">
					<div className="max-w-2xl">
						<p className="text-xs font-bold uppercase tracking-wider text-mg-orange">Our range</p>
						<h2 className="mt-2 text-2xl font-bold text-mg-dark sm:text-3xl">Packaging supplies for every trade</h2>
						<p className="mt-3 text-sm text-gray-500">
							Buy in single cartons or by the pallet. Mix and match categories and we will consolidate everything into one delivery.
						</p>
					</div>

					<div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
						{products.map((product) => (
							<div key={product.name} className="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
								<div className="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-mg-orange">
									<i className={`fa-solid ${product.icon}`}></i>
								</div>
								<h3 className="mt-4 font-bold text-mg-dark">{product.name}</h3>
								<p className="mt-1.5 text-sm text-gray-500">{product.description}</p>
							</div>
						))}
					</div>
				</div>
			</section>

			{/* WHY US */}
			<section id="why-us" className="border-y border-gray-200 bg-white py-16 sm:py-20">
				<div className="mx-auto max-w-7xl px-4 sm:px-6">
					<div className="max-w-2xl">
						<p className="text-xs font-bold uppercase tracking-wider text-mg-orange">Why MG Packaging</p>
						<h2 className="mt-2 text-2xl font-bold text-mg-dark sm:text-3xl">Stock you can rely on, delivery you can plan around</h2>
					</div>

					<div className="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
						{features.map((feature) => (
							<div key={feature.title}>
								<div className="flex h-11 w-11 items-center justify-center rounded-xl bg-mg-dark text-mg-orange">
									<i className={`fa-solid ${feature.icon}`}></i>
								</div>
								<h3 className="mt-4 font-bold text-mg-dark">{feature.title}</h3>
								<p className="mt-1.5 text-sm text-gray-500">{feature.description}</p>
							</div>
						))}
					</div>
				</div>
			</section>

			{/* CONTACT */}
			<section id="contact" className="bg-mg-dark text-white">
				<div className="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center">
					<div>
						<h2 className="text-2xl font-bold sm:text-3xl">Need a bulk quote?</h2>
						<p className="mt-2 text-sm text-gray-400">Tell us what you ship and we will put a packaging plan together for you.</p>
					</div>

					<div className="flex flex-wrap items-center gap-3">
						<a href="tel:+959123456789" className="inline-flex items-center gap-2 rounded-xl bg-mg-orange px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-mg-orange/25 transition-colors hover:bg-mg-orange-hover">
							<i className="fa-solid fa-phone text-xs"></i>
							09 123 456 789
						</a>
						<a href="mailto:sales@mgpackaging.com" className="inline-flex items-center gap-2 rounded-xl border border-gray-700 px-4 py-3 text-sm font-semibold text-gray-200 transition-colors hover:border-mg-orange hover:text-mg-orange">
							<i className="fa-solid fa-envelope text-xs"></i>
							sales@mgpackaging.com
						</a>
					</div>
				</div>
			</section>

			{/* FOOTER */}
			<footer className="border-t border-gray-800 bg-mg-dark px-4 py-8 sm:px-6">
				<div className="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 sm:flex-row">
					<div className="flex items-center gap-2.5">
						<div className="flex h-8 w-8 items-center justify-center rounded-lg bg-mg-orange text-xs font-bold text-white">MG</div>
						<span className="text-sm font-bold text-white">
							MG <span className="text-mg-orange">Packaging</span>
						</span>
					</div>
					<p className="text-xs text-gray-500">&copy; 2026 MG Packaging Co., Ltd. All rights reserved.</p>
				</div>
			</footer>
		</div>
	)
}
