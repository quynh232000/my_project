'use client';
import { createContext, useContext, useState } from 'react';

interface ForgotPasswordContextType {
	email: string;
	setEmail?: (email: string) => void;
}

const ForgotPasswordContext = createContext<
	ForgotPasswordContextType | undefined
>(undefined);

const ForgotPasswordProvider = ({
	children,
}: {
	children: React.ReactNode;
}) => {
	const [email, setEmail] = useState('');
	return (
		<ForgotPasswordContext.Provider
			value={{
				email,
				setEmail,
			}}>
			{children}
		</ForgotPasswordContext.Provider>
	);
};

const useForgotPasswordContext = () => {
	const context = useContext(ForgotPasswordContext);
	if (context === undefined) {
		throw new Error(
			'useForgotPasswordContext must be used within a ForgotPasswordProvider'
		);
	}
	return context;
};

export { ForgotPasswordProvider, useForgotPasswordContext };
