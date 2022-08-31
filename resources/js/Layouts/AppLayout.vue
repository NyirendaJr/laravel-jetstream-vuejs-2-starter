<template>
    <v-app dark>
        <div class="admin">
            <app-drawer ref="drawer" class="admin_drawer" @drawer:collapsed="mini = !mini"/>
            <app-toolbar class="admin_toolbar" extended @side-icon-click="handleDrawerVisible"/>
            <v-main style="background-color: #f4f7fc">
                <v-toolbar dense flat>
                    <v-toolbar-title>
                        <slot name="header" />
                    </v-toolbar-title>
                    <v-spacer />
                    <v-toolbar-title>
                        <slot name="header-right" />
                    </v-toolbar-title>
                </v-toolbar>

                <div class="page_wrapper">
                    <slot />
                </div>

                <v-footer height="auto" class="pa-3 app--footer">
                    <span>thelabdev.com Design &copy; 2022</span>
                </v-footer>
            </v-main>

            <app-fab/>
        </div>

        <v-btn fab dark fixed top="top" right="right" class="chat-fab" color="primary" @click="openOnlineUser">
            <v-icon>mdi-silverware-variant</v-icon>
        </v-btn>

        <v-navigation-drawer v-model="rightDrawer" class="setting-drawer" temporary right hide-overlay fixed>
            <template>

            </template>
        </v-navigation-drawer>

        <!-- global snackbar -->
        <v-snackbar v-model="snackbar.show" :timeout="3000" app top centered :color="snackbar.color">
            {{ snackbar.text }}
            <template #action="{ attrs }">
                <v-btn icon v-bind="attrs" @click="$store.commit('HIDE_SNACKBAR')">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>

    </v-app>
</template>

<script>
import AppDrawer from '@/components/AppDrawer'
import AppToolbar from '@/components/AppToolbar'
import AppFab from '@/components/AppFab'
import {mapGetters} from 'vuex'

export default {
    components: {
        AppDrawer,
        AppToolbar,
        AppFab,
    },
    data() {
        return {
            rightDrawer: false,
            showSetting: true,
            mini: false,
            showDrawer: true,
        }
    },
    computed: {
        ...mapGetters(['getSnackbar']),
        snackbar: {
            get() {
                return this.getSnackbar
            },
            set(val) {
                this.$store.commit('UPDATE_SNACKBAR', val)
            },
        },
    },
    mounted() {
        if (typeof window !== undefined && window._VMA === undefined) {
            window._VMA = this
        }
    },
    created() {
    },
    methods: {
        openThemeSettings() {
            this.$vuetify.goTo(0)
            this.showSetting = true
            this.rightDrawer = !this.rightDrawer
        },
        openOnlineUser() {
            this.$vuetify.goTo(0)
            this.showSetting = false
            this.rightDrawer = !this.rightDrawer
        },
        handleDrawerVisible() {
            this.$refs.drawer.toggleDrawer()
        },
    },
}
</script>

<style lang="sass" scoped>
.setting-fab
    top: 50% !important
    right: 0
    border-radius: 0

.chat-fab
    top: calc(50% + 40px) !important
    right: 0
    border-radius: 0

.page_wrapper
    min-height: calc(100vh - 112px - 48px)
    padding: 50px 20px 0 20px

.container
    max-width: 1200px
</style>
