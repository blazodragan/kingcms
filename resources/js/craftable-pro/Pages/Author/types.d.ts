import type { UploadedFile } from "craftable-pro/types";

export type Author = {
    id: string | number; 
name: string; 
email: string; 
created_at: string; 
updated_at: string; 
deleted_at: string
    media?: UploadedFile[];
};

export type AuthorForm = {
    name: string; 
email: string; 
cover: Array<UploadedFile>
};
