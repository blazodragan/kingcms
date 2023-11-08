export type UserForm = UserPasswordForm &
  UserProfileForm & {
    locale: string;
    about: string;
    facebook: string;
    twitter: string;
    linkedin: string;
    slug: string;
    active: boolean;
    role_id: number | null;
  };

export type UserPasswordForm = {
  password: string;
  password_confirmation: string;
};

export type UserProfileForm = {
  first_name: string;
  last_name: string;
  about: string;
  facebook: string;
  twitter: string;
  linkedin: string;
  slug: string;
  email: string;
  locale: string;
  avatar: [];
};


export type UserInviteUserForm = {
    email: string
    role_id: string,
}

export type InviteUserForm = {
    first_name: string;
    last_name: string;
    email: string;
    locale: string;
    password: string;
    password_confirmation: string;
    avatar: [];
};
