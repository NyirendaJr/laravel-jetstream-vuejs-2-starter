<template>
    <v-app>
        <v-card
            color="grey lighten-4"
            flat
            height="200px"
            outlined
        >
            <v-toolbar flat>
                <v-toolbar-title>
                    <v-img
                        :alt="platformName"
                        contain height="64px"
                        position="center center"
                        src="/images/new-logo-removebg-preview.png"
                    />
                </v-toolbar-title>

                <v-spacer />

                <Link v-if="$page.props.user" href="/dashboard">
                    <v-btn text>
                        Dashboard
                    </v-btn>
                </Link>

                <template v-else>
                    <inertia-link :href="route('login')">
                        <v-btn text>
                            Login
                        </v-btn>
                    </inertia-link>

                    <inertia-link v-if="canRegister" :href="route('register')">
                        <v-btn text>
                            Register
                        </v-btn>
                    </inertia-link>
                </template>

            </v-toolbar>
        </v-card>

        <v-main class="grey lighten-4">
            <v-container>

            </v-container>

            <v-footer height="auto" class="pt-30 app--footer">
                <span>thelabdev.com Design &copy; 2022</span>
            </v-footer>

        </v-main>
    </v-app>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue";

export default {
    components: {
        Link
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
    data() {
        return {
            platformName: 'TITLE'
        }
    }
}
</script>
