import CountryAndDialOrPhoneCodes from '@/lib/seeds/country/CountryAndDialOrPhoneCodes.json';

export type TCountryAndDialOrPhoneCodes = {
	name: string;
	code: string;
};

const ListCountry: { [key: string]: TCountryAndDialOrPhoneCodes } =
	CountryAndDialOrPhoneCodes;
export { ListCountry };
