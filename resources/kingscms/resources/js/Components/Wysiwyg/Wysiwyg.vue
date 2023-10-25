<template>
  <FormControl :name="name" :label="label" :error="error">
    <div
      class="relative block w-full rounded-md border bg-white text-gray-800 shadow-sm focus-within:outline-none focus-within:ring-1"
      :class="{
        'border-red-300 placeholder-red-300 focus-within:border-red-500 focus-within:ring-red-500':
          !!error,
        'focus-within:border-primary-500 focus-within:ring-primary-500 border-gray-300':
          !error,
      }"
    >
      <div
        v-if="!withoutToolbar"
        class="flex flex-wrap items-center gap-2  border-b border-gray-300 px-2 py-1.5"
      >
        <div class="flex flex-wrap gap-1">
          <HeadingSelect :editor="editor" />
        </div>

        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().toggleBold().run()"
            :active="editor?.isActive('bold')"
            title="⌘B"
            :icon="BoldIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleItalic().run()"
            :active="editor?.isActive('italic')"
            title="⌘I"
            :icon="ItalicIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleUnderline().run()"
            :active="editor?.isActive('underline')"
            title="⌘U"
            :icon="UnderlineIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleStrike().run()"
            :active="editor?.isActive('strike')"
            title="⌘⇧X"
            :icon="StrikeIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleCode().run()"
            :active="editor?.isActive('code')"
            title="⌘E"
            :icon="CodeIcon"
          />
        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().setTextAlign('left').run()"
            :active="editor?.isActive({ textAlign: 'left' })"
            title="⌘⇧L"
            :icon="TextAlignLeftIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('center').run()"
            :active="editor?.isActive({ textAlign: 'center' })"
            title="⌘⇧E"
            :icon="TextAlignCenterIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('right').run()"
            :active="editor?.isActive({ textAlign: 'right' })"
            title="⌘⇧R"
            :icon="TextAlignRightIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('justify').run()"
            :active="editor?.isActive({ textAlign: 'justify' })"
            title="⌘⇧J"
            :icon="TextAlignJustifyIcon"
          />
        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().toggleOrderedList().run()"
            :active="editor?.isActive('orderedList')"
            title="⌘⇧7"
            :icon="OrderedListIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleBulletList().run()"
            :active="editor?.isActive('bulletList')"
            title="⌘⇧8"
            :icon="BulletListIcon"
          />
          <ToolbarButton
            @click="toggleView"
            title="⌘⇧8"
            :icon="HtmlIcon"
          />

          <!-- Button to toggle between views -->

        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <LinkPromptModal :editor="editor" @linkAdded="setLink" />
          <ToolbarButton
            @click="editor?.chain().toggleBlockquote().run()"
            :active="editor?.isActive('blockquote')"
            title="⌘⇧B"
            :icon="BlockquoteIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleCodeBlock().run()"
            :active="editor?.isActive('codeBlock')"
            title="⌘⎇C"
            :icon="CommandLineIcon"
          />
          <ImageUploadButton @imageUploaded="addImage" />
          <YoutubePromptModal @youtubeAdded="addVideo" />

          <ToolbarButton
            @click="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()"
            :active="editor?.isActive('addTable')"
            title="Insert Table"
            :icon="AddTable"
          />
          <ToolbarButton
            @click="editor.chain().focus().deleteTable().run()"
            :active="editor?.isActive('deleteTable')"
            title="Delete Table"
            :icon="DeleteTable"
          />

          <ToolbarButton
          @click="editor.chain().focus().addRowAfter().run()"
            :active="editor?.isActive('addRow')"
            title="Add Row"
            :icon="AddRow"
          />

          <ToolbarButton
          @click="editor.chain().focus().addColumnAfter().run()"
            :active="editor?.isActive('addColumn')"
            title="Add Column"
            :icon="AddColumn"
          />



        </div>
          <BlocksSelect :editor="editor" />
          <TemplateSelect :editor="editor" />

        
      </div>
      <div class="relative">
        <div v-if="isRichTextView">
          <bubble-menu
      :editor="editor"
      :tippy-options="{ duration: 100 }"
      v-if="editor"
    >
            <div
        v-if="!withoutToolbar"
        class="flex flex-wrap items-center gap-2  border-b border-gray-300 px-2 py-1.5 bg-white rounded shadow-md"
      >
      <div class="flex flex-wrap gap-1">
          <HeadingSelect :editor="editor" />
        </div>

        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().toggleBold().run()"
            :active="editor?.isActive('bold')"
            title="⌘B"
            :icon="BoldIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleItalic().run()"
            :active="editor?.isActive('italic')"
            title="⌘I"
            :icon="ItalicIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleUnderline().run()"
            :active="editor?.isActive('underline')"
            title="⌘U"
            :icon="UnderlineIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleStrike().run()"
            :active="editor?.isActive('strike')"
            title="⌘⇧X"
            :icon="StrikeIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleCode().run()"
            :active="editor?.isActive('code')"
            title="⌘E"
            :icon="CodeIcon"
          />
        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().setTextAlign('left').run()"
            :active="editor?.isActive({ textAlign: 'left' })"
            title="⌘⇧L"
            :icon="TextAlignLeftIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('center').run()"
            :active="editor?.isActive({ textAlign: 'center' })"
            title="⌘⇧E"
            :icon="TextAlignCenterIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('right').run()"
            :active="editor?.isActive({ textAlign: 'right' })"
            title="⌘⇧R"
            :icon="TextAlignRightIcon"
          />
          <ToolbarButton
            @click="editor?.chain().setTextAlign('justify').run()"
            :active="editor?.isActive({ textAlign: 'justify' })"
            title="⌘⇧J"
            :icon="TextAlignJustifyIcon"
          />
        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <ToolbarButton
            @click="editor?.chain().toggleOrderedList().run()"
            :active="editor?.isActive('orderedList')"
            title="⌘⇧7"
            :icon="OrderedListIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleBulletList().run()"
            :active="editor?.isActive('bulletList')"
            title="⌘⇧8"
            :icon="BulletListIcon"
          />
          <ToolbarButton
            @click="toggleView"
            title="⌘⇧8"
            :icon="HtmlIcon"
          />

          <!-- Button to toggle between views -->

        </div>
        <div class="flex flex-wrap gap-1 pl-2">
          <LinkPromptModal :editor="editor" @linkAdded="setLink" />
          <ToolbarButton
            @click="editor?.chain().toggleBlockquote().run()"
            :active="editor?.isActive('blockquote')"
            title="⌘⇧B"
            :icon="BlockquoteIcon"
          />
          <ToolbarButton
            @click="editor?.chain().toggleCodeBlock().run()"
            :active="editor?.isActive('codeBlock')"
            title="⌘⎇C"
            :icon="CommandLineIcon"
          />
          <ImageUploadButton @imageUploaded="addImage" />
          <YoutubePromptModal @youtubeAdded="addVideo" />

          <ToolbarButton
            @click="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()"
            :active="editor?.isActive('addTable')"
            title="Insert Table"
            :icon="AddTable"
          />
          <ToolbarButton
            @click="editor.chain().focus().deleteTable().run()"
            :active="editor?.isActive('deleteTable')"
            title="Delete Table"
            :icon="DeleteTable"
          />

          <ToolbarButton
          @click="editor.chain().focus().addRowAfter().run()"
            :active="editor?.isActive('addRow')"
            title="Add Row"
            :icon="AddRow"
          />

          <ToolbarButton
          @click="editor.chain().focus().addColumnAfter().run()"
            :active="editor?.isActive('addColumn')"
            title="Add Column"
            :icon="AddColumn"
          />



        </div>
  
        
      </div>
        
    </bubble-menu>
  <EditorContent :editor="editor" />
  <!-- Plus any other UI elements related to the tiptap editor -->
</div>

<!-- Raw HTML view -->
<div v-else>
  <textarea v-model="rawHtmlContent" class="w-full h-60"></textarea>
</div>

        <div
          v-if="error"
          class="pointer-events-none absolute inset-y-0 right-0 top-3 items-center pr-3"
        >
          <ExclamationCircleIcon
            class="h-5 w-5 text-red-500"
            aria-hidden="true"
          />
        </div>
      </div>


    </div>
  </FormControl>
</template>

<script setup lang="ts">
import { withDefaults, watch, ref, computed } from "vue";
import { mergeAttributes,Node} from '@tiptap/core';
import { useEditor, EditorContent, BubbleMenu } from "@tiptap/vue-3";
import { Editor } from "@tiptap/core";
import { EditorView } from "prosemirror-view";
import { EditorState } from "prosemirror-state";
import StarterKit from "@tiptap/starter-kit";
import Link from "@tiptap/extension-link";
import Heading  from "@tiptap/extension-heading";
import Underline from "@tiptap/extension-underline";
import TextAlign from "@tiptap/extension-text-align";
import Youtube from "@tiptap/extension-youtube";
import Image from "@tiptap/extension-image";
import Table from '@tiptap/extension-table'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import TableRow from '@tiptap/extension-table-row'
import {
  BlockquoteIcon,
  BoldIcon,
  BulletListIcon,
  CodeIcon,
  ItalicIcon,
  OrderedListIcon,
  StrikeIcon,
  TextAlignCenterIcon,
  TextAlignJustifyIcon,
  TextAlignLeftIcon,
  TextAlignRightIcon,
  UnderlineIcon,
  HtmlIcon,
  CommandLineIcon,
  AddTable,
  DeleteTable,
  AddColumn,
  AddRow,
} from "./icons";

import ToolbarButton from "./ToolbarButton.vue";
import HeadingSelect from "./HeadingSelect.vue";
import BlocksSelect from "./BlocksSelect.vue";
import TemplateSelect from "./TemplateSelect.vue";
import ImageUploadButton from "./ImageUploadButton.vue";
import { isFileImage } from "kingcms/helpers";
import YoutubePromptModal from "./YoutubePromptModal.vue";
import LinkPromptModal from "./LinkPromptModal.vue";
import { UploadedFile } from "kingcms/types";
import { usePage } from "@inertiajs/vue3";
import { PageProps } from "../../types/page";
import { FormControl } from "..";
import { ExclamationCircleIcon } from "@heroicons/vue/20/solid";

interface Props {
  name: string;
  label?: string;
  modelValue?: string;
  withoutToolbar?: boolean;
}


const props = withDefaults(defineProps<Props>(), {
  modelValue: "",
  withoutToolbar: false,
});

const emit = defineEmits(["update:modelValue"]);

const error = computed(
  () => (usePage().props as PageProps)?.errors[props.name] ?? false
);


watch(
  () => props.modelValue,
  (value) => {
    const isSame = editor.value?.getHTML() === value;

    if (isSame) {
      return;
    }

    editor.value?.commands.setContent(value, false);
  }
);


const editor = useEditor({
  content: props.modelValue,
  extensions: [   
    StarterKit,
    // Section,
    // DivNode,
    // HeaderNode,
    // SvgNode,
    // PathNode,
    Heading,
    Table.configure({
      resizable: true,
    }),
    TableRow,
    TableHeader,
    TableCell,
//  Heading.configure({
//   levels: [1,2,3,4,5,6], // For h1
//   HTMLAttributes: {
//     class: 'text-4xl mb-10 text-[#0c87c6]',
//   },
// }),
    Underline,
    Link.configure({
      openOnClick: false,
    }),

    TextAlign.configure({
      types: ["heading", "paragraph"],
    }),
    Youtube.configure({
      width: 640,
      height: 360,
      nocookie: true,
    }),
    Image.configure({
      inline: true,
    }),
  ],
  editorProps: {
    attributes: {
      class:
        "min-h-[160px] max-w-none prose sm:prose-sm prose-p:!my-0 prose-ul:!my-0 prose-li:!my-0 prose-img:!inline py-2 px-3 text-gray-800",
    },
  },
  onUpdate: () => {
    if ((usePage().props as PageProps)?.errors[props.name]) {
      (usePage().props as PageProps).errors[props.name] = false;
    }
    emit("update:modelValue", editor.value?.getHTML());
  },
});


const setLink = (url: string) => {
  // empty
  if (url === "") {
    editor.value?.chain().focus().extendMarkRange("link").unsetLink().run();

    return;
  }

  // update link
  editor.value
    ?.chain()
    .focus()
    .extendMarkRange("link")
    .setLink({ href: url })
    .run();
};

const addVideo = (value?: string) => {
  if (value) {
    editor.value?.commands.setYoutubeVideo({
      src: value,
    });
  }
};

const addImage = (mediaArr: UploadedFile[] | UploadedFile) => {
  if (!Array.isArray(mediaArr)) {
    mediaArr = [mediaArr];
  }

  mediaArr.forEach((media) => {
    if (media.original_url) {
      if (isFileImage(media.original_url)) {
        editor.value
          ?.chain()
          .focus()
          .insertContent(
            `<p><img src="${media.original_url}" alt="${
              media.custom_properties?.alt ?? media.file_name
            }" /></p>`
          )
          .run();
      } else {
        editor.value
          ?.chain()
          .focus()
          .insertContent(
            `<a href="${media.original_url}">${
              media.custom_properties?.name ?? media.file_name
            }</a>`
          )
          .run();
      }
    }
  });
};

// State to track the current view (true for rich-text view, false for HTML view)
const isRichTextView = ref(true);

// Model for the textarea where raw HTML will be edited
const rawHtmlContent = ref<string>('');

// Function to toggle between rich-text and HTML views
const toggleView = () => {
  if (isRichTextView.value) {
    rawHtmlContent.value = editor.value?.getHTML() || '';
  } else {
    editor.value?.commands.setContent(rawHtmlContent.value);
  }
  emit("update:modelValue", editor.value?.getHTML());
  isRichTextView.value = !isRichTextView.value;
};



const Section = Node.create({
  name: 'section',

  group: 'block',

  content: 'block*',

  parseHTML() {
    return [{ tag: 'section' }];
  },

  renderHTML({ HTMLAttributes }) {
    return ['section', HTMLAttributes, 0];
  },
});
const DivNode = Node.create({
    name: 'div',
    group: 'block',
    content: 'block+',
    attrs: {
    class: {
            default: null,
        },
    },
    addAttributes() {
        return {
            class: {
                parseHTML: element => element.getAttribute('class'),
            }
        }
    },
    parseHTML() {
        return [
            {
                tag: 'div',
            },
        ];
    },
    renderHTML({ node, HTMLAttributes }) {
        return ['div', HTMLAttributes, 0];
    },
});

const HeaderNode = Node.create({
    name: 'header',
    group: 'block',
    content: 'block*',

    addAttributes() {
        return {
            class: {
                parseHTML: element => element.getAttribute('class'),
            }
        }
    },
    parseHTML() {
        return [
            {
                tag: 'header',
            },
        ];
    },

    renderHTML({ node, HTMLAttributes }) {
        return ['header', HTMLAttributes, 0];
    },
});

const SvgNode = Node.create({
    name: 'svg',
    group: 'block',
    content: 'block*',

    addAttributes() {
        return {
          xmlns: {
                parseHTML: element => element.getAttribute('xmlns'),
            },
            height: {
                parseHTML: element => element.getAttribute('height'),
            },
            viewBox: {
                parseHTML: element => element.getAttribute('viewBox'),
            },
            class: {
                parseHTML: element => element.getAttribute('class'),
            },
            fill: {
                parseHTML: element => element.getAttribute('fill'),
            }
        }
    },
    parseHTML() {
        return [
            {
                tag: 'svg',
            },
        ];
    },

    renderHTML({ node, HTMLAttributes }) {
        return ['svg', HTMLAttributes, 0];
    },
});
const PathNode = Node.create({
    name: 'path',
    group: 'block',
    content: 'block*',

    addAttributes() {
        return {
            d: {
                parseHTML: element => element.getAttribute('d'),
            }
        }
    },
    parseHTML() {
        return [
            {
                tag: 'path',
            },
        ];
    },

    renderHTML({ node, HTMLAttributes }) {
        return ['path', HTMLAttributes, 0];
    },
});

</script>

<style>
.ProseMirror:focus {
  outline: none;
}
</style>
