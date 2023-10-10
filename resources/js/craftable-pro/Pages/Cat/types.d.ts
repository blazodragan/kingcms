import type { UploadedFile } from "craftable-pro/types";

export type Cat = {
    id: string | number; 
slug: Record<string, string>; 
title: Record<string, string>; 
description: Record<string, string>; 
active: boolean; 
created_at: string; 
updated_at: string
    media?: UploadedFile[];
};

export type CatForm = {
    slug: Record<string, string>; 
title: Record<string, string>; 
description: Record<string, string>; 
active: boolean; 
cover: Array<UploadedFile>
};
