import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';


interface props {
    data_value: string
    category_slug?: string,
    related?: boolean
}

export interface IPostItem {
    id: number
    name: string
    slug: string
    category_id: number
    content: any
    created_by: number
    created_at: string
    image: string
    author: Author
    category: Category
    related: IPostItem[],
    description: string
}

export interface Author {
    id: number
    full_name: string
}

export interface Category {
    id: number
    name: string
    slug: string
    parent_id: number
}

export const SGetPostDetail = async (params: props): Promise<IPostItem | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.POST_DETAIL}`, {
            ...params,
        });
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetPostDetail', error);
        return null;
    }
};
