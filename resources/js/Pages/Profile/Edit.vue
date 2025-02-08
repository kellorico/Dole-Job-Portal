<script setup>
import UpdateInfo from './partials/UpdateInfo.vue';
import UpdatePassword from './partials/UpdatePassword.vue';
import DeleteAccount from './partials/DeleteAccount.vue';
import Main from '@/Layouts/Main.vue';
defineProps({
    user:Object,
    status: String
})
</script>

<template>
    <Main>
        <Head title="- Profile"/>
        <UpdateInfo :user="user" :status="status"/>
        <UpdatePassword :status="status"/>
        <DeleteAccount/>
    </Main>
</template>
