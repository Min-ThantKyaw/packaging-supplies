type MgLogoProps = {
	className?: string
}

export const MgLogo = ({ className = "h-10 w-10" }: MgLogoProps) => {
	return (
		<svg className={className} viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<path d="M40 75 L100 40 L100 80 L70 98 L70 140 L40 120 Z" fill="#F26522" />
			<path d="M100 80 L100 40 L130 58 L100 130 L70 110 Z" fill="#FF7A29" />
			<path d="M100 80 L160 45 L160 120 L100 155 Z" fill="#2B313E" />
			<path d="M115 100 L160 75 L160 95 L130 112 L130 135 L115 125 Z" fill="#1F242D" />
		</svg>
	)
}
