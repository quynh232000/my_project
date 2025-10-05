import { create } from 'zustand/react';




type SearchSelect = {
	name: string;
	slug: string;
	type: string;
	page: string;
};

type SearchSelectType = SearchSelect & {
	setSearchSelected: (item: SearchSelect) => void;
};
export const initialState: SearchSelect = {
	name: '',
	slug: '',
	type: '',
	page: '',
};


export const useHeadSearchStore = create<SearchSelectType>((set) => ({
	...initialState,
	setSearchSelected: ({ name, slug, type, page }) =>
		set(() => ({ name, slug, type, page })),
}));
