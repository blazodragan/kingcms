import type { UploadedFile } from "kingcms/types";

export type News = {
    id: string | number; 
title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
reference_link: string; 
meta_title: Record<string, string>; 
meta_description: Record<string, string>; 
meta_url_canolical: Record<string, string>; 
href_lang: Record<string, string>; 
no_index: boolean; 
no_follow: boolean; 
og_title: Record<string, string>; 
og_description: Record<string, string>; 
og_type: Record<string, string>; 
og_url: Record<string, string>; 
user_id: string; 
status: string;
published_at: string; 
created_at: string; 
updated_at: string; 
deleted_at: string
    media?: UploadedFile[];
};

export type NewsForm = {
    title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
reference_link: string; 
meta_title: Record<string, string>; 
meta_description: Record<string, string>; 
meta_url_canolical: Record<string, string>; 
href_lang: Record<string, string>; 
no_index: boolean; 
no_follow: boolean; 
og_title: Record<string, string>; 
og_description: Record<string, string>; 
og_type: Record<string, string>; 
og_url: Record<string, string>; 
user_id: string; 
status: string;
published_at: string; 
cover: Array<UploadedFile>; 
og_cover: Array<UploadedFile>
};
