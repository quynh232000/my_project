import { CounterProvider } from '@/components/context/CounterContext';
import { ForgotPasswordProvider } from '@/components/context/auth/ForgotPasswordContext';

export default function Layout({ children }: { children: React.ReactNode }) {
	return (
		<CounterProvider initial={{ count: 1, min: 1, max: 4 }}>
			<ForgotPasswordProvider>{children}</ForgotPasswordProvider>
		</CounterProvider>
	);
}
