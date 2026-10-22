import { api } from "../../lib/axios"

export const Dashboard = () => {
	const response = async () => {
		const response = await api.get('/auth/health')
		console.log(response.data);
		return response
	}
	console.log(response());
	return (
		<div>
			<h1 className="">Dashboard</h1>
			
		</div>
	)
}