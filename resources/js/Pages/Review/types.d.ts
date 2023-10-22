import type { UploadedFile } from "kingcms/types";

export type Review = {
    id: string | number; 
title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
text: Record<string, string>; 
active: boolean; 
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
faqs: Array<{ question: string, answer: string }>;
tips: Array<{ title: string, body: string , icon: string, type: string}>;
};

export type ReviewForm = {
title: Record<string, string>; 
slug: Record<string, string>; 
perex: Record<string, string>; 
content: Record<string, string>; 
text: Record<string, string>; 
active: boolean; 
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
cover_review: Array<UploadedFile>; 
og_cover_review: Array<UploadedFile>
faqs: Array<{ question: string, answer: string }>;
tips: Array<{ title: string, body: string , icon: string, type: string}>;
};
