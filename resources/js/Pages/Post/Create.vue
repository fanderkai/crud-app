<template>
    <form @submit.prevent="submit">
        <label for="title">Title</label>
        <input type="text" id="title" v-model="form.title" />
        <label for="body">Body</label>
        <input type="text" id="body" v-model="form.body" />
        <button type="submit">Submit</button>
    </form>
</template>

<script setup>
import { onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  post: {
    type: Object,
    default: null,
  },
  isUpdating: {
    type: Boolean,
    default: false,
  },
});

const form = useForm({
  title: "",
  body: "",
});

const submit = () => (props.isUpdating ? updatePost() : addPost());
const addPost = () => form.post("/posts");
const updatePost = () => form.put(`/posts/${props.post.id}`);
onMounted(() => {
  form.title = props.post.title;
  form.body = props.post.body;
});
</script>
<style lang="scss" scoped></style>