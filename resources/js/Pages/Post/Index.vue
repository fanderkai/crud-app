<template>
    <div>
    <h1>My Inertia CRUD</h1>
    <Link href="posts/create">Create new Post</Link>
    <table>
        <thead>
        <tr>
            <th v-for="header in headers" :key="header">
            {{ header }}
            </th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="post in posts" :key="post.id">
                <td>{{ post.title }}</td>
                <td>{{ post.body }}</td>
                <td>
                    <button @click="deletePost(post.id)">Delete</button>
                    <Link :href="`posts/${post.id}/edit`">Edit</Link>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
  posts: {
    type: Array,
    default: () => [],
  },
});

const headers = ["title", "body", "actions"];

const form = useForm({});

const deletePost = (id) => {
    form.delete(`posts/${id}`);
};
</script>