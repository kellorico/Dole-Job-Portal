<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";
import ErrorMessages from "../../../Components/ErrorMessages.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
    status: String,
});

const form = useForm({
    username: props.user.username,
    email: props.user.email,
    gender: props.user.gender || "",
    date_of_birth: props.user.date_of_birth || "",
    address: props.user.address || "",
    city: props.user.city || "",
    region: props.user.region || "",
    country: props.user.country || "",
    zip_code: props.user.zip_code || "",
    about_me: props.user.about_me || "",
});
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address and more.</p>

            <ErrorMessages :errors="form.errors" />
            <SessionMessages v-if="form.recentlySuccessful" :status="status" />
            <form
                @submit.prevent="form.patch(route('profile.info'))"
                class="space-y-6"
            >
                <InputField
                    label="User Name"
                    icon="id-badge"
                    class="w-1/2"
                    v-model="form.username"
                />

                <InputField
                    label="Email"
                    icon="at"
                    class="w-1/2"
                    v-model="form.email"
                />

                <InputField
                    label="Gender"
                    icon="venus-mars"
                    class="w-1/2"
                    v-model="form.gender"
                    placeholder="Male, Female, or Other"
                />

                <InputField
                    label="Date of Birth"
                    icon="calendar"
                    class="w-1/2"
                    type="date"
                    v-model="form.date_of_birth"
                />

                <InputField
                    label="Address"
                    icon="map-marker-alt"
                    class="w-1/2"
                    v-model="form.address"
                />

                <InputField
                    label="City"
                    icon="city"
                    class="w-1/2"
                    v-model="form.city"
                />

                <InputField
                    label="Region"
                    icon="map"
                    class="w-1/2"
                    v-model="form.region"
                />

                <InputField
                    label="Country"
                    icon="globe"
                    class="w-1/2"
                    v-model="form.country"
                />

                <InputField
                    label="ZIP Code"
                    icon="envelope"
                    class="w-1/2"
                    v-model="form.zip_code"
                />

                <InputField
                    label="About Me"
                    icon="info-circle"
                    class="w-1/2"
                    type="textarea"
                    v-model="form.about_me"
                />

                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </form>
        </div>
    </Container>
</template>
