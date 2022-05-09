<template>
    <app-layout>

    </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/AppLayout";
    export default {
        components: {
            AppLayout
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    }
</script>
