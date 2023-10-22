import type { UploadedFile } from "kingcms/types";

export type Pages = {
id: string | number; 
title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
meta_title: Record<string, string>; 
meta_description: Record<string, string>; 
meta_url_canolical: Record<string, string>; 
href_lang: Record<string, string>; 
is_index: boolean; 
no_index: boolean; 
no_follow: boolean; 
og_title: Record<string, string>; 
og_description: Record<string, string>; 
og_type: Record<string, string>; 
og_url: Record<string, string>; 
user_id: string; 
template: string; 
status: string;
published_at: string; 
created_at: string; 
updated_at: string; 
deleted_at: string;
faqs: Array<{ question: string, answer: string }>;
tips: Array<{ title: string, body: string , icon: string, type: string}>;
media?: UploadedFile[];

};

export type PagesForm = {
title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
meta_title: Record<string, string>; 
meta_description: Record<string, string>; 
meta_url_canolical: Record<string, string>; 
href_lang: Record<string, string>; 
is_index: boolean; 
no_index: boolean; 
no_follow: boolean; 
og_title: Record<string, string>; 
og_description: Record<string, string>; 
og_type: Record<string, string>; 
og_url: Record<string, string>; 
user_id: string; 
template: string; 
status: string;
published_at: string; 
faqs: Array<{ question: string, answer: string }>;
tips: Array<{ title: string, body: string , icon: string, type: string}>;
cover: Array<UploadedFile>; 
og_cover: Array<UploadedFile>
};
