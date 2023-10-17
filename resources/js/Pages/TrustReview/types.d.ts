import type { UploadedFile } from "craftable-pro/types";

export type trustReview = {
id: string | number; 
title: Record<string, string>; 
description: Record<string, string>; 
rating: number;
created_at: string; 
updated_at: string
};

export type trustReviewForm = {
title: Record<string, string>; 
description: Record<string, string>; 
rating: number;
};
