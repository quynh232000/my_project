import { create } from 'zustand/react';

import { LanguageStore } from '@/store/languages/type';
import { getLanguage, ILanguage } from '@/services/language/getLanguage';

export const useLanguageStore = create<LanguageStore>((set, get) => ({
	languageList: [] as ILanguage[],
	fetchLanguageList: async () => {
		if (get().languageList && get().languageList.length === 0) {
			const languageList = await getLanguage();
			if (languageList && languageList.length > 0) {
				return set({ languageList });
			} else {
				set({ languageList: [] });
			}
		}
	},
}));
