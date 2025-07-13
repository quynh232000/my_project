import { useEffect, useRef, useCallback } from 'react';

type DebounceCallback<T extends unknown[]> = (...args: T) => void;

const useDebounce = <T extends unknown[]>(
	callback: DebounceCallback<T>,
	wait: number
) => {
	const argsRef = useRef<T | undefined>(undefined);
	const timeout = useRef<NodeJS.Timeout | null>(null);

	const cleanup = useCallback(() => {
		if (timeout.current !== null) {
			clearTimeout(timeout.current);
			timeout.current = null;
		}
	}, []);

	useEffect(() => cleanup, [cleanup]);

	return (...args: T) => {
		argsRef.current = args;

		cleanup();

		timeout.current = setTimeout(() => {
			if (argsRef.current) {
				callback(...argsRef.current);
			}
		}, wait);
	};
};

export default useDebounce;
