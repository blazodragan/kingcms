import type { UploadedFile } from "kingcms/types";

export type Block = {
    id: string | number; 
    name: Record<string, string>; 
    type: Record<string, string>; 
    content: Record<string, string>; 
    created_at: string; 
    updated_at: string
    
};

export type BlockForm = {
    alias: string; 
    name: Record<string, string>; 
    type: Record<string, string>; 
    content: Record<string, string>; 
    
};