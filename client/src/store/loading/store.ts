import { create } from 'zustand/react';
import { LoadingActions, LoadingState } from '@/store/loading/type';

const initialState: LoadingState = {
	loading: false,
};

export const useLoadingStore = create<LoadingState & LoadingActions>((set) => ({
	...initialState,
	setLoading: (loading: boolean) => set({ loading }),
}));
