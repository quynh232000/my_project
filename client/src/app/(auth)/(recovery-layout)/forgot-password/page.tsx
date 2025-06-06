'use client';

import EmailCheck from '@/containers/auth/forgot-password/EmailCheck';
import OTPVerification from '@/containers/auth/forgot-password/OTPVerification';
import NewPassword from '@/containers/auth/forgot-password/NewPassword';
import SuccessScreen from '@/containers/auth/forgot-password/SuccessScreen';
import { useCounterContext } from '@/components/context/CounterContext';

export default function Page() {
	switch (useCounterContext().count) {
		case 1:
			return <EmailCheck />;
		case 2:
			return <OTPVerification />;
		case 3:
			return <NewPassword />;
		case 4:
			return <SuccessScreen />;
		default:
			return <EmailCheck />;
	}
}
