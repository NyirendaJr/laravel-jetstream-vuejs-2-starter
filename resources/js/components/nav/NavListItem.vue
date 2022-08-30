<template>
    <jet-responsive-nav-link
        :active="route().current(item.name)"
        :href="route(item.name)"
        v-if="checkPermission(item.permissions)"
    >
        <v-list-item>
            <v-list-item-icon>
                <v-tooltip bottom>
                    <template #activator="{ on, attrs }">
                        <v-icon v-bind="attrs" v-on="on" v-text="item.icon"/>
                    </template>
                    <span v-text="item.title"/>
                </v-tooltip>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title v-text="item.title"/>
            </v-list-item-content>
            <v-list-item-action v-if="item.isNew">
                <v-icon color="green">mdi-new-box</v-icon>
            </v-list-item-action>
        </v-list-item>
    </jet-responsive-nav-link>
</template>

<script>
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink';
import JetNavLink from '@/Jetstream/NavLink'
import checkPermission from "@/utils/permissions";

export default {
    props: {
        item: Object,
    },
    computed: {},
    components: {
        JetResponsiveNavLink,
        JetNavLink
    },
    methods: {
        checkPermission
    }
}
</script>
