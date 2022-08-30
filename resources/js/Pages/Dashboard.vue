<template>
    <app-layout>

        <template #header>
            Dashboard
        </template>

        <v-container>
            <h1>Build your professional dashboard here</h1>
        </v-container>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
