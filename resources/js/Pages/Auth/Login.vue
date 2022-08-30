<template>
    <v-app class="primary">
        <v-card
            color="grey lighten-4"
            flat
            height="200px"
            outlined
        >
            <v-toolbar flat>
                <v-toolbar-title>
                    <Link href="/">
                        <v-img
                            alt="MAUZOMKONONI"
                            contain height="64px"
                            position="center center"
                            src="/images/new-logo-removebg-preview.png"
                        />
                    </Link>
                </v-toolbar-title>
            </v-toolbar>
        </v-card>

        <v-main class="grey lighten-4">
            <v-container>
                <div class="flex flex-row space-x-64 justify-content-between">
                    <div>
                        <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
                            <div class="relative h-full max-w-7xl mx-auto">
                                <svg class="absolute right-full transform translate-y-1/4 translate-x-1/4 lg:translate-x-1/2" width="404" height="484" fill="none" viewBox="0 0 404 784">
                                    <defs>
                                        <pattern id="f210dbf6-a58d-4871-961e-36d5016a0f49" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                            <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-gray-800" fill="currentColor"/>
                                        </pattern>
                                    </defs>
                                    <rect width="404" height="784" fill="url(#f210dbf6-a58d-4871-961e-36d5016a0f49)" />
                                </svg>
                                <svg class="absolute left-full transform -translate-y-3/4 -translate-x-1/4 md:-translate-y-1/2 lg:-translate-x-1/2 text-gray-200 dark:text-gray-800" width="404" height="784" fill="none" viewBox="0 0 404 784">
                                    <defs>
                                        <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                            <rect x="0" y="0" width="4" height="4" fill="currentColor" />
                                        </pattern>
                                    </defs>
                                    <rect width="404" height="784" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)" />
                                </svg>
                            </div>
                        </div>
                        <div class="relative z-10 px-6 pt-16 md:pt-24 md:pb-24">
                            <h2 class="relative z-10 pb-6 text-3xl sm:text-5xl md:text-5xl lg:text-7.5xl font-black tracking-snug text-center leading-11 sm:leading-15 md:leading-18 lg:leading-22 text-gray-800 dark:text-white">
                                <span class="flex space-x-4 justify-center">
                                  <span>{{ $t("front.hero.headline2") }}</span>
                                </span>
                                <span class="text-gray-300 mt-2">
                                  {{ $t("front.hero.headline3") }}
                                </span>
                            </h2>
                            <div class="relative z-10 pb-10 text-gray-700 text-lg md:text-2xl text-center leading-normal md:leading-9">
                                <p class="sm:text-lg max-w-2xl mx-auto">{{ $t("front.hero.headline4") }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <v-card
                            width="600px"
                            outlined
                        >
                            <v-card-title>
                                <v-layout align-center justify-space-between>
                                    <v-flex>
                                        <h1 class="display-1">Login</h1>
                                    </v-flex>
                                </v-layout>
                            </v-card-title>
                            <v-divider />
                            <v-card-text>
                                <v-alert dense outlined type="error" v-if="$page.props.loginError">
                                    {{ $page.props.loginError }}
                                </v-alert>
                                <v-form ref="form" v-model="formValid" class="my-10" lazy-validation>
                                    <v-text-field
                                        v-model="form.email"
                                        :error-messages="form.errors.name"
                                        append-icon="mdi-email"
                                        autocomplete="off"
                                        name="login"
                                        :label="$t('email')"
                                        :placeholder="$t('email')"
                                        type="text"
                                        required
                                        outlined
                                        dense
                                    />
                                    <v-text-field
                                        v-model="form.password"
                                        :error-messages="form.errors.email"
                                        append-icon="mdi-lock"
                                        autocomplete="off"
                                        name="password"
                                        :label="$t('password')"
                                        :placeholder="$t('password')"
                                        type="password"
                                        required
                                        outlined
                                        @keyup.enter="handleLogin"
                                        dense
                                    />
                                </v-form>
                                <v-btn
                                    tile
                                    color="primary"
                                    :loading="loading"
                                    @click="handleLogin"
                                    block
                                >
                                    {{ $t('login') }}
                                </v-btn>
                            </v-card-text>
                        </v-card>
                    </div>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue";

export default {
    name: 'PageLogin',
    components: {
        Link
    },
    props: ['loginError'],
    data() {
        return {
            loading: false,
            formValid: false,
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            }),
            platformName: 'TITLE',
        }
    },

    methods: {
        handleLogin() {
            if (this.$refs.form.validate()) {
                this.loading = true
                this.form
                    .transform(data => ({
                        ...data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => {
                            this.loading = false
                            this.form.reset('password')
                            console.log(this.$page.props)
                        }
                    })
            }
        },
    },
}
</script>
