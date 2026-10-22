import axios from "axios";

const BASE_URI = "http://127.0.0.1:8000/api/";

export const api = axios.create({
	baseURL: BASE_URI,
	timeout: 10000,
	headers: {
		'Content-Type': 'applicaton/json',
	},
});
