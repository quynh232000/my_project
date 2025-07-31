import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';


interface props {
    limit?: number
    slug: string
    with_items?: boolean
}

export interface IPostCategoryItem {
    name: string
    id: number
    slug: string
    image: string
    items: Item[]
}

export interface Item {
    id: number
    name: string
    slug: string
    created_at: string
    category_id: number
    created_by: number
    image: string
    author: Author
}

export interface Author {
    id: number
    full_name: string
    avatar: string
}

export const SGetPostCategoryList = async (params: props): Promise<IPostCategoryItem[] | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.POST_CATEGORY_LIST}`, {
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
