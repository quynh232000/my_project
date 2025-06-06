export const validatePasswordCriteria = (password: string) => {
	const numberRegex = new RegExp('.*[0-9].*');
	const minPasswordLength = new RegExp('.{8,}');
	const upperCaseRegex = new RegExp('.*[A-Z].*');
	const lowerCaseRegex = new RegExp('.*[a-z].*');

	return {
		hasNumber: numberRegex.test(password),
		hasUpperCase: upperCaseRegex.test(password),
		hasLowerCase: lowerCaseRegex.test(password),
		isMinLength: minPasswordLength.test(password),
	};
};
