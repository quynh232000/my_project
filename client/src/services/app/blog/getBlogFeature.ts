import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';


interface props {
	slug: string
	limit?: number
	page?: number
	all_parent?: boolean
	type?: string
}

export interface IPostItem {
	id: number
	name: string
	slug: string
	created_at: string
	category_id: number
	created_by: number
	image: string
	author: Author
	category: Category
}

export interface Author {
	id: number
	full_name: string
	avatar: string
}

export interface Category {
	id: number
	slug: string
	name: string
}
export interface IPostList {
	current_page: number
	total_page: number
	total_item: number
	per_page: number
	list: IPostItem[]
	category: Category2
}
export interface Category2 {
	id: number
	name: string
	slug: string
	image: string
	description: string
	content: string
	parent_id: number
}

export const getPostList = async (params: props): Promise<IPostList | null> => {
	try {
		const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.POST_LIST}`, {
			...params,
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getPostList', error);
		return null;
	}
};
