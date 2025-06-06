export interface LoadingState {
	loading: boolean;
}

export interface LoadingActions {
	setLoading: (loading: boolean) => void;
}
