export type UserRole = 'admin' | 'seller';

export interface User {
	id: string;
	name: string;
	email: string;
	phone: string | null;
	shopName: string | null;
	role: UserRole;
	locale: string;
}

export interface LoginPayload {
	email: string;
	password: string;
	remember: boolean;
}

export interface LoginResponse {
	user: User;
	token: AuthToken;
}

export interface AuthToken {
  accessToken: string;
}
