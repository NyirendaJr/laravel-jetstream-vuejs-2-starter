
<template>

    <app-layout>

        <template v-slot:header>
            All Users
        </template>

        <template v-slot:header-right>
            <v-btn dark small color="success" @click="back">
                <v-icon dark>
                    mdi-arrow-left
                </v-icon>
                Back
            </v-btn>
        </template>

        <v-toolbar flat class="grey lighten-3">

            <v-spacer />

            <v-btn
                color="primary"
                @click="openNewUserDialog"
            >
                <v-icon>mdi-plus</v-icon>
                Add user
            </v-btn>
        </v-toolbar>

        <v-container>
            <v-row>
                <v-col cols="12">

                    <v-text-field
                        label="Search"
                        placeholder="Search..."
                        single-line
                    />

                    <v-card outlined>
                        <v-card-text>
                            <v-data-table
                                :headers="userTableHeader"
                                :items="users"
                                :loading="usersTableLoading"
                            >

                                <template #[`item.is_active`]="{item}">
                                    <v-chip
                                        color="green"
                                        text-color="white"
                                        v-if="item.is_active"
                                    >
                                        Active
                                    </v-chip>

                                    <v-chip
                                        color="red"
                                        text-color="white"
                                        v-else
                                    >
                                        Blocked
                                    </v-chip>

                                </template>


                                <template #[`item.actions`]="{ item }">
                                    <div class="text-center">
                                        <v-menu offset-y>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn color="primary" text v-bind="attrs" v-on="on">
                                                    <v-icon>mdi-menu</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-list>
                                                <Link
                                                    :href="route('admin.users.show', item.id)"
                                                >
                                                    <v-list-item link>
                                                        <v-list-item-title>
                                                            <v-icon>mdi-eye</v-icon>
                                                            View
                                                        </v-list-item-title>
                                                    </v-list-item>
                                                </Link>

                                                <v-list-item
                                                    link
                                                    @click="openEditUseDialog(item)"
                                                >
                                                    <v-list-item-title>
                                                        <v-icon>mdi-pencil</v-icon>
                                                        Edit
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </div>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>

        <progress-bar :visible="progressBarVisible" />


        <!-- register user dialog -->
        <v-dialog
            persistent
            max-width="924"
            v-model="newUserDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    Register New User
                </v-card-title>
                <v-divider />
                <v-card-text>
                    <validation-observer
                        ref="newUserFormValidation"
                    >
                        <v-form ref="newUserForm">
                            <validation-provider v-slot="{ errors }" name="name">
                                <v-text-field
                                    v-model="user.name"
                                    label="Full Name"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>

                            <validation-provider v-slot="{ errors }" name="email">
                                <v-text-field
                                    v-model="user.email"
                                    label="Email"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>

                            <validation-provider v-slot="{ errors }" name="phone_number">
                                <v-text-field
                                    v-model="user.phone_number"
                                    label="Phone Number"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>
                        </v-form>
                    </validation-observer>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text @click="newUserDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        tile
                        color="success"
                        @click="createUser"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- edit user dialog -->
        <v-dialog
            persistent
            max-width="924"
            v-model="editUserDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    Edit User
                </v-card-title>
                <v-divider />
                <v-card-text>
                    <validation-observer
                        ref="editUserFormValidation"
                    >
                        <v-form ref="editUserForm">
                            <validation-provider v-slot="{ errors }" name="name">
                                <v-text-field
                                    v-model="user.name"
                                    label="Full Name"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>

                            <validation-provider v-slot="{ errors }" name="email">
                                <v-text-field
                                    v-model="user.email"
                                    label="Email"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>

                            <validation-provider v-slot="{ errors }" name="phone_number">
                                <v-text-field
                                    v-model="user.phone_number"
                                    label="Phone Number"
                                    :error-messages="errors[0]"
                                    outlined
                                    dense
                                />
                            </validation-provider>

                        </v-form>
                    </validation-observer>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text @click="editUserDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        tile
                        color="success"
                        @click="editUser"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        Update
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import API from "@/api";
import ProgressBar from "@/components/core/ProgressBar";
import {Link} from "@inertiajs/inertia-vue";
import {ValidationObserver, ValidationProvider} from "vee-validate";
import commonMixins from "@/mixins/commonMixins";

export default {
    name: "AdminUsersIndex",
    mixins: [commonMixins],
    components: {
        AppLayout,
        ProgressBar,
        Link,
        ValidationProvider,
        ValidationObserver
    },
    data(){
        return {
            userTableHeader: [
                {text: 'S/N', value: 'serial_number'},
                {text: 'NAME', value: 'name'},
                {text: 'EMAIL', value: 'email'},
                {text: 'PHONE', value: 'phone_number'},
                {text: 'STATUS', value: 'is_active'},
                {text: 'ACTIONS', value: 'actions', align: 'center'}
            ],
            users: [],
            companies: [],
            user: {},
            currentUser: {},
            usersTableLoading: false,
            listQuery: {
                keyword: '',
                per_page: 10,
                page: 1
            },
            progressBarVisible: false,
            newUserDialog: false,
            editUserDialog: false
        }
    },

    created() {
        this.getUsers()
    },

    methods:{
        async getUsers(){
            this.usersTableLoading = true
            const {data} = await API.User.getUsers(this.listQuery);
            this.users = data
            this.users.forEach((element, index) => {
                element['serial_number'] = (this.listQuery.page - 1) * this.listQuery.per_page + index + 1;
            })
            this.usersTableLoading = false
        },

        async createUser() {
            this.progressBarVisible = true
            try {
                const response = await API.User.createUser(this.user)
                const {error, message} = response
                if (error) {
                    this.progressBarVisible = false
                    this.$refs.newUserFormValidation.setErrors(message)
                } else {
                    this.progressBarVisible = false
                    this.$refs.newUserForm.reset()
                    this.newUserDialog = false
                    await this.getUsers()
                    this.$toast.success('User created successfully')
                }
            } catch (e) {
                this.progressBarVisible = true
                this.$toast.error(e.message)
            }
        },

        openNewUserDialog() {
            this.newUserDialog = true
        },

        openEditUseDialog(item) {
            this.currentUser = item
            this.user.name = item.name
            this.user.email = item.email
            this.user.phone_number = item.phone_number
            this.editUserDialog = true
        },


        async editUser() {

            this.progressBarVisible = true

            try {
                const response = await API.User.updateUser(this.currentUser.id, this.user)
                const {error, message} = response
                if (error) {
                    this.progressBarVisible = false
                    this.$refs.editUserFormValidation.setErrors(errors)
                } else {
                    this.progressBarVisible = false
                    this.$refs.editUserForm.reset()
                    this.editUserDialog = false
                    await this.getUsers()
                    this.$toast.success(message)
                }
            } catch (e) {
                this.progressBarVisible = true
                this.$toast.error(e.message)
            }
        },
    }

}
</script>

<style scoped>

</style>
