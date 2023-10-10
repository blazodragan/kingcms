<script setup>
import Modal from "./Modal.vue";
import { DocumentPlusIcon } from "@heroicons/vue/24/outline";
import InputLabel from "@/Components/InputLabel.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import ColorButton from "@/Components/ColorButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Tagable from "@/Components/Tagable.vue";
import { ref, computed, onMounted, onUnmounted,nextTick } from "vue";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["close"]);
const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxWidth: {
    type: String,
    default: "4xl",
  },
  closeable: {
    type: Boolean,
    default: true,
  },
  tags: Object,
});

const close = () => {
  emit("close");

};

// Keyword logic
const mainColors = [
  { color: "bg-rose-600" },
  { color: "bg-fuchsia-600" },
  { color: "bg-purple-600" },
  { color: "bg-violet-600" },
  { color: "bg-indigo-600" },
  { color: "bg-blue-600" },
  { color: "bg-sky-600" },
  { color: "bg-cyan-600" },
  { color: "bg-teal-600" },
  { color: "bg-emerald-600" },
  { color: "bg-green-600" },
  { color: "bg-lime-600" },
  { color: "bg-yellow-600" },
  { color: "bg-amber-600" },
  { color: "bg-orange-600" },
  { color: "bg-red-600" },
  { color: "bg-stone-600" },
  { color: "bg-neutral-600" },
  { color: "bg-zinc-600" },
  { color: "bg-gray-600" },
  { color: "bg-pink-600" },
];

const groupStatus = ref(false);
const groupColor = ref('bg-rose-600');
const alltags = ref(null);

// photo
const photoPreview = ref(null);
const photoInput = ref(null);

const selectNewPhoto = () => {
  photoInput.value.click();
};

const updatePhotoPreview = () => {
  const photo_path = photoInput.value.files[0];

  if (!photo_path) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };
  reader.readAsDataURL(photo_path);
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};



const form = useForm({
  name: "",
  photo_path:null,
  tags: alltags,
  status: groupStatus,
  groupColor: groupColor,
});

const submitForm = () => {
  if (photoInput.value) {
    form.photo_path = photoInput.value.files[0];
  }
  form.post("groups.store", {
    _method: "PUT",
    preserveScroll: true,
    onSuccess: () => {
      return Promise.all([form.reset(),emit("close"),removeAllTags(alltags),photoPreview.value=null]);
    },
  });
};
function changeColor(newColor) {
  groupColor.value = newColor;
  console.log(groupColor.value);
}
const clickSubmit = (e) => {
    if (e.key === "s" && (e.altKey || e.metaKey) && props.show === true) {
      e.preventDefault();
      form.processing = false;
      nextTick().then(submitForm());
    }
};

onMounted(() =>
document.addEventListener('keydown', clickSubmit)
);

onUnmounted(() => {
  document.removeEventListener('keydown', clickSubmit)
});


function removeAllTags(alltags){
  alltags.length = 0
}

function removeTag(alltags, tagIndex) {
  if (alltags[tagIndex] !== undefined) {
    alltags.splice(tagIndex, 1);
  }
}


</script>

<template>
  <Modal
    :show="props.show"
    :max-width="props.maxWidth"
    :closeable="props.closeable"
    @close="close"
  >
    <div class="bg-white px-4 pt-5 sm:p-6 sm:pb-0">
      <div
        class="
          flex
          justify-between
          items-center
          pb-4
          mb-4
          rounded-t
          border-b
          sm:mb-5
        "
      >
        <div class="flex items-center">
          <div
            class="
              flex
              mr-2
              flex-shrink-0
              items-center
              justify-center
              bg-green-200
              h-12
              w-12
              rounded-xl
            "
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
              class="w-6 h-6 text-green-700"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z"
              ></path>
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-xl text-gray-500 leading-tight">
              Add New Groups
            </h3>
            <span class="text-sm text-gray-400"
              >Make sure the groups are unique</span
            >
          </div>
        </div>
        <button
          type="button"
          @click="close"
          class="
            text-gray-400
            bg-transparent
            hover:bg-gray-200 hover:text-gray-900
            rounded-lg
            text-sm
            p-1.5
            ml-auto
            inline-flex
            items-center
          "
        >
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <span class="sr-only">Close modal</span>

        </button>
        <kbd class="ml-2 px-2 py-1.5 text-xs font-semibold text-black bg-gray-100 border-gray-200 border-2 rounded-lg">esc</kbd>
      </div>
    </div>
    <form @submit.prevent="submitForm">
      <div class="max-w-full mx-auto px-8 pb-8">
        <div class="grid gap-4 sm:grid-cols-3">
                    <!-- Enable -->
                    <div class="col-span-6 sm:col-span-4">
            <InputLabel for="Status" value="Status" />
            <label
              for="large-toggle-keyword"
              class="inline-flex relative items-center cursor-pointer"
            >
              <input
                type="checkbox"
                v-model="form.status"
                :checked="groupStatus"
                id="large-toggle-keyword"
                class="sr-only peer"
              />
              <div
                class="
                  w-14
                  h-7
                  bg-gray-200
                  peer-focus:outline-none
                  peer-focus:ring-4
                  peer-focus:ring-blue-300
                  dark:peer-focus:ring-blue-800
                  rounded-full
                  peer
                  dark:bg-gray-700
                  peer-checked:after:translate-x-full
                  peer-checked:after:border-white
                  after:content-['']
                  after:absolute
                  after:top-0.5
                  after:left-[4px]
                  after:bg-white
                  after:border-gray-300
                  after:border
                  after:rounded-full
                  after:h-6
                  after:w-6
                  after:transition-all
                  dark:border-gray-600
                  peer-checked:bg-blue-600
                "
              ></div>
            </label>
          </div>

          <div class="col-span-6 sm:col-span-4">
                  <!-- Profile Photo File Input -->
                  <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                  />

                  <InputLabel for="photo" value="Photo" />

                  <!-- Current Profile Photo -->
                  <!-- New Profile Photo Preview -->
                  <div v-show="photoPreview" class="mt-2">
                    <span
                      class="
                        block
                        rounded-sm
                        w-auto
                        h-44
                        bg-cover bg-no-repeat bg-center
                      "
                      :style="
                        'background-image: url(\'' + photoPreview + '\');'
                      "
                    />
                  </div>

                  <SecondaryButton
                    class="mt-2 mr-2"
                    type="button"
                    @click.prevent="selectNewPhoto"
                  >
                    Select A New Photo
                  </SecondaryButton>


                  <InputError :message="form.errors.photo_path" class="mt-2" />
                </div>
                          <!-- Name -->
          <div class="sm:col-span-4">
            <InputLabel for="Name" value="Name" />
            <TextInput
              autofocus
              id="name"
              v-model="form.name"
              type="text"
              class="block w-full"
              autocomplete="name"
            />
            <InputError :message="form.errors.name" />
          </div>
                              <!-- select tags -->
                              <div class="col-span-6 sm:col-span-4">
            <InputLabel for="tags" value="Tags" />
            <div class="col-span-6 sm:col-span-4">
              <Tagable v-model="form.tags" :tags="props.tags" />
              <InputError :message="form.errors.tags" />
            </div>
          </div>
          <div v-if="form.tags" class="vue-tags col-span-4 relative">
            <div v-if="(form.tags.length > 0)" class="absolute top-0 right-0 p-0.5 hover:bg-gray-400 bg-gray-200 hover:text-gray-900 cursor-pointer rounded-full" @click.stop="removeAllTags(form.tags)">
              <svg aria-hidden="true" class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </div>
              <div v-for="(tag,index) in form.tags" :key="tag" class="vue-tag selected">{{ tag }} <span @click.stop="removeTag(form.tags, index)"></span>
              </div>
            </div>


          <!-- Color -->
          <div class="col-span-6 sm:col-span-4">
            <div class="flex items-center pb-2 text-gray-900 bg-white">
              <span class="mr-2">Group Color</span
              ><span class="w-5 h-5 rounded-full" :class="[groupColor]"></span>
            </div>
            <div class="col-span-6 sm:col-span-4">
              <ColorButton
                v-for="item in mainColors"
                :key="item.color"
                :color="item.color"
                v-model="groupColor"
                @click.prevent="changeColor(item.color)"
              />
            </div>
          </div>

        </div>
      </div>
      <div
        class="
          flex flex-row
          justify-between
          w-full
          px-6
          py-4
          bg-gray-100
          text-right
        "
      >
        <SecondaryButton @click="close"> Cancel </SecondaryButton>
        <div>
          <ActionMessage :on="form.recentlySuccessful" class="ml-3">
            Saved.
          </ActionMessage>
          <PrimaryButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Add Group
            {{ form.progress ? `${form.progress.percentage}%` : "" }}
            <kbd class="ml-2 mr-1 px-1 text-xs font-semibold text-black bg-indigo-200 border border-indigo-300 rounded-lg">alt</kbd> + <kbd class="ml-1 px-1 text-xs font-semibold text-black bg-indigo-200 border border-indigo-300 rounded-lg">s</kbd>
          </PrimaryButton>


        </div>
      </div>
    </form>
  </Modal>
</template>
