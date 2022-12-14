<template>
    <v-app-bar color="primary" dark app>
        <v-app-bar-nav-icon @click="handleDrawerToggle"/>

        <v-spacer />

        <v-toolbar-items>
            <v-menu offset-y origin="center center" class="elevation-1" transition="scale-transition">
                <template #activator="{ on }">
                    <v-btn slot="activator" icon text v-on="on">
                        <v-badge color="red" overlap>
                            <span slot="badge">{{ getNotification.length }}</span>
                            <v-icon medium>mdi-bell</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <notification-list v-show="getNotification.length > 0" :items="getNotification"/>
            </v-menu>

            <!-- locale -->
            <LocaleSwitch/>

            <v-menu offset-y origin="center center" transition="scale-transition">
                <template #activator="{ on }">
                    <v-btn slot="activator" icon large text v-on="on">
                        <c-avatar :size="36" username="user" :src="getAvatar" status="online"/>
                    </v-btn>
                </template>
                <v-list class="pa-0">
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon>mdi-account-box</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                user
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        v-for="(item, index) in profileMenus"
                        :key="index"
                        :disabled="item.disabled"
                        :target="item.target"
                        rel="noopener"
                        @click="item.click"
                    >
                        <v-list-item-action v-if="item.icon">
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ item.title }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-toolbar-items>
    </v-app-bar>
</template>
<script>
import NotificationList from '@/components/NotificationList'
import LocaleSwitch from '@/components/LocaleSwitch'
import CAvatar from '@/components/CAvatar'
import Util from '@/utils'
import {mapGetters} from 'vuex'

export default {
    name: 'AppToolbar',
    components: {
        LocaleSwitch,
        NotificationList,
        CAvatar,
    },
    props: {
        extended: Boolean,
    },
    data() {
        return {
            profileMenus: [
                {
                    icon: 'mdi-account',
                    href: '#',
                    title: 'Profile',
                    click: this.handleProfile,
                },
                {
                    icon: 'mdi-power',
                    href: '#',
                    title: 'Logout',
                    click: this.handleLogut,
                },
            ],
        }
    },
    computed: {
        ...mapGetters(['getAvatar', 'getUsername', 'getNotification']),
        breadcrumbs() {
            const {matched} = this.$route
            return matched.map((route, index) => {
                const to = index === matched.length - 1 ? this.$route.path : route.path || route.redirect
                const text = this.$t(route.meta.title)
                return {
                    text: text,
                    to: to,
                    exact: true,
                    disabled: false,
                }
            })
        },
    },
    created() {
    },
    methods: {
        handleDrawerToggle() {
            this.$emit('side-icon-click')
        },
        handleFullScreen() {
            Util.toggleFullScreen()
        },
        handleLogut() {
            this.$inertia.post(route('logout'));
        },

        handleSetting() {
        },
        handleProfile() {
            this.$inertia.get(route('profile.show'))
        },
        handleGoBack() {
            this.$router.go(-1)
        },
    },
}
</script>

