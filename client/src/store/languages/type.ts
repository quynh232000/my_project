import { ILanguage } from '@/services/language/getLanguage';


export interface LanguageStore {
	languageList: ILanguage[];
	fetchLanguageList: () => Promise<void>;
}
