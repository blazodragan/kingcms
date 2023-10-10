<template>
  <div>
    <nav class="mt-5 space-y-1">
      <SidebarGroup :title="$t('craftable-pro', 'Content')">
        <SidebarItem
          :href="route('craftable-pro.media.index')"
          :icon="PhotoIcon"
          v-can="'craftable-pro.media.index'"
        >
          {{ $t("craftable-pro", "Media") }}
        </SidebarItem>
        <SidebarItem
                        :href="route('craftable-pro.categories.index')"
                        :icon="CubeTransparentIcon"
                        v-can="'craftable-pro.category.index'"
                    >
                        {{ $t("craftable-pro", "Categories") }}
                    </SidebarItem>
                    <SidebarItem
                        :href="route('craftable-pro.news.index')"
                        :icon="CubeTransparentIcon"
                        v-can="'craftable-pro.news.index'"
                    >
                        {{ $t("craftable-pro", "News") }}
                    </SidebarItem>
                    <SidebarItem
                        :href="route('craftable-pro.cats.index')"
                        :icon="CubeTransparentIcon"
                        v-can="'craftable-pro.cat.index'"
                    >
                        {{ $t("craftable-pro", "Cats") }}
                    </SidebarItem>
                    <SidebarItem
                        :href="route('craftable-pro.authors.index')"
                        :icon="CubeTransparentIcon"
                        v-can="'craftable-pro.author.index'"
                    >
                        {{ $t("craftable-pro", "Authors") }}
                    </SidebarItem>
                    <SidebarItem
                        :href="route('craftable-pro.reviews.index')"
                        :icon="CubeTransparentIcon"
                        v-can="'craftable-pro.review.index'"
                    >
                        {{ $t("craftable-pro", "Reviews") }}
                    </SidebarItem>
                    <!--AppendGeneratorLink-->
      </SidebarGroup>

      <SidebarGroup
        :title="$t('craftable-pro', 'System')"
        v-can:any="[
          'craftable-pro.craftable-pro-user.index',
          'craftable-pro.role.index',
          'craftable-pro.translation.index',
          'craftable-pro.settings.edit',
        ]"
      >
        <SidebarItem
          :href="route('craftable-pro.craftable-pro-users.index')"
          :icon="UsersIcon"
          v-can="'craftable-pro.craftable-pro-user.index'"
        >
          {{ $t("craftable-pro", "Access") }}
        </SidebarItem>
        <SidebarItem
          :href="route('craftable-pro.roles.index')"
          :icon="KeyIcon"
          v-can="'craftable-pro.role.index'"
        >
          {{ $t("craftable-pro", "Roles") }}
        </SidebarItem>
        <SidebarItem
          :href="route('craftable-pro.translations.index')"
          :icon="LanguageIcon"
          v-can="'craftable-pro.translation.index'"
        >
          {{ $t("craftable-pro", "Localization") }}
        </SidebarItem>
        <SidebarItem
          :href="route('craftable-pro.settings.index')"
          :icon="Cog8ToothIcon"
          v-can="'craftable-pro.settings.edit'"
        >
          {{ $t("craftable-pro", "Settings") }}
        </SidebarItem>
      </SidebarGroup>
    </nav>
  </div>
</template>

<script setup lang="ts">
import {
  KeyIcon,
  LanguageIcon,
  PhotoIcon,
  UsersIcon,
  Cog8ToothIcon,
  CubeTransparentIcon,
} from "@heroicons/vue/24/outline";
import { SidebarItem, SidebarGroup } from "craftable-pro/Components";
</script>
