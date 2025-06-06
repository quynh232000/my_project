import { Input } from '@/components/ui/input';
import { InputHTMLAttributes, useState } from 'react';
import { EyeIcon, EyeOffIcon } from 'lucide-react';
import { cn } from '@/lib/utils';

interface Props extends InputHTMLAttributes<HTMLInputElement> {
	password: string;
	setPassword: (password: string) => void;
	placeholder?: string;
	className?: string;
}

const InputPassword = ({ password, setPassword, placeholder, className="", ...props }: Props) => {
	const [showPassword, setShowPassword] = useState(false);
	return (
		<div className="relative">
			<Input
				className={cn(className)}
				type={showPassword ? 'text' : 'password'}
				placeholder={placeholder}
				onChange={(event) => setPassword(event.target.value)}
				value={password}
				{...props}
			/>
			<button
				type="button"
				className="absolute right-3 top-1/2 -translate-y-1/2"
				onClick={() => setShowPassword(!showPassword)}>
				{showPassword ? (
					<EyeIcon className="h-5 w-5 text-gray-500" />
				) : (
					<EyeOffIcon className="h-5 w-5 text-gray-500" />
				)}
			</button>
		</div>
	);
};

export default InputPassword;
