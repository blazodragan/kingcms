import {reactive} from "vue";

export default reactive({
  items: [],
  add(toast) {
    if (this.items.length === 0) {
    this.items.unshift({
      key: Symbol(),
      ...toast
    });
  }},
  remove(index) {
    this.items.splice(index, 1);
  },
});