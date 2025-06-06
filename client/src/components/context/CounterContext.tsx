'use client';
import { createContext, useContext } from 'react';
import { useCounter } from '@uidotdev/usehooks';

interface CounterContextType {
	count: number;
	incrementCount: () => void;
	decrementCount: () => void;
	resetCount: () => void;
	setCount?: (count: number) => void;
}

interface Props {
	children: React.ReactNode;
	initial?: {
		count: number;
		min: number;
		max: number;
	};
}

const CounterContext = createContext<CounterContextType | undefined>(undefined);

const CounterProvider = ({
	children,
	initial = { count: 1, min: 1, max: 4 },
}: Props) => {
	const [count, { increment, decrement, reset, set }] = useCounter(
		initial.count,
		{
			min: initial.min,
			max: initial.max,
		}
	);
	return (
		<CounterContext.Provider
			value={{
				count,
				incrementCount: increment,
				decrementCount: decrement,
				resetCount: reset,
				setCount: set,
			}}>
			{children}
		</CounterContext.Provider>
	);
};

const useCounterContext = () => {
	const context = useContext(CounterContext);
	if (context === undefined) {
		throw new Error('useCounterContext must be used within a CounterProvider');
	}
	return context;
};

export { CounterProvider, useCounterContext };
