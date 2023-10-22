import { watch, Ref } from 'vue';

export function useCopyOnWatch<T>(
  sourceRef: Ref<T>, 
) {
  watch(sourceRef, (newValue) => {
    console.log('Source value changed:', newValue);
});
}