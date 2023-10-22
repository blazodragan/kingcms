import type { UploadedFile } from "kingcms/types";

export type Category = {
    id: string | number; 
alias: string; 
slug: Record<string, string>; 
title: Record<string, string>; 
description: Record<string, string>; 
type: string;
created_at: string; 
updated_at: string
    media?: UploadedFile[];
};

export type CategoryForm = {
alias: string; 
slug: Record<string, string>; 
title: Record<string, string>; 
description: Record<string, string>; 
type: string;
cover: Array<UploadedFile>
};
