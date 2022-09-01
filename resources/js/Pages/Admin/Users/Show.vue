
<template>
    <app-layout>

        <template v-slot:header>
            User profile
        </template>

        <template v-slot:header-right>
            <v-btn dark small color="success" @click="back">
                <v-icon dark>
                    mdi-arrow-left
                </v-icon>
                Back
            </v-btn>
        </template>

        <v-container fluid>
            <v-row>
                <v-col cols="6" sm="12" md="4">
                    <h2 class="text-xl font-weight-regular">
                        {{ user.name }}
                    </h2>
                </v-col>
                <v-col cols="12" sm="12" md="8" class="text-md-right">
                    <v-chip
                        color="green"
                        text-color="white"
                        v-if="user.is_active"
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
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                v-bind="attrs"
                                v-on="on"
                                rounded
                                elevation="1"
                            >
                                Action Menu
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item
                                link
                                @click="openResetPasswordConfirmDialog"
                                v-if="checkPermission(['reset_user_password'])"
                            >
                                <v-list-item-title>
                                    <v-icon>mdi-lock-off</v-icon>
                                    Recover password
                                </v-list-item-title>
                            </v-list-item>

                            <v-list-item
                                v-if="user.is_active"
                                link
                                @click="openChangeUserStatusConfirmDialog"
                            >
                                <v-list-item-title>
                                    <v-icon>mdi-account-lock</v-icon>
                                    Block
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                v-else
                                link
                                @click="openChangeUserStatusConfirmDialog"
                            >
                                <v-list-item-title>
                                    <v-icon>mdi-account-lock</v-icon>
                                    Un Block
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
            </v-row>
        </v-container>

        <v-divider />
        <v-container
            fluid
        >
            <v-row>
                <v-col cols="12" md="8">
                    <v-card outlined>
                        <v-tabs
                            v-model="tab"
                            show-arrows
                        >
                            <v-tab>roles</v-tab>
                        </v-tabs>

                        <v-divider/>

                        <v-tabs-items v-model="tab">
                            <v-tab-item>
                                <v-card outlined>
                                    <v-toolbar flat>
                                        <v-spacer />
                                        <v-btn
                                            color="default"
                                            text
                                            @click="openAddRoleToUserDialogForm"
                                        >
                                            <v-icon>mdi-plus</v-icon>
                                            Add role
                                        </v-btn>
                                    </v-toolbar>

                                    <v-divider />

                                    <v-card-text>
                                        <v-data-table
                                            :items="userAssignedRoles"
                                            :headers="userAssignedRolesTableHeaders"
                                        >

                                            <template #[`item.actions`]="{item}">
                                                <v-btn
                                                    @click="openReassignRoleFromUserConfirmDialog(item)"
                                                    color="red"
                                                    text
                                                    class="text-center"
                                                >
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </template>
                                        </v-data-table>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-card
                        outlined
                    >
                        <v-card-title>
                            Details
                        </v-card-title>

                        <v-divider/>

                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                    <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ user.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ user.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number</th>
                                        <td>{{ user.phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Is Active</th>
                                        <td>{{ user.is_active ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registered Date</th>
                                        <td>{{ user.created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Login At</th>
                                        <td>{{ user.last_login_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Login IP Address</th>
                                        <td>{{ user.last_login_ip_address }}</td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>


        <progress-bar :visible="progressBarVisible" />


        <!-- recover user password confirm dialog -->
        <v-dialog
            v-model="resetPasswordConfirmDialog"
            persistent
            max-width="624"
        >
            <v-card>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    Recover user password?
                </v-card-title>
                <v-card-text>
                    Are you sure you want to recover password for <strong>{{ user.name }}</strong> ? This will send an email to <strong>{{ user.email }}</strong> with a new password.
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="resetPasswordConfirmDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        tile
                        color="error"
                        @click="resetUserPassword"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--block user confirm dialog---->
        <v-dialog
            v-model="changeUserStatusConfirmDialog"
            persistent
            max-width="624"
        >
            <v-card>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    {{ user.is_active ? 'Block user' : 'Un block user' }}
                </v-card-title>
                <v-card-text>
                    Are you sure you want to {{ user.is_active ? 'block' : 'un block' }} <strong>{{ user.name }}</strong> ? This will {{ user.is_active ? 'block' : 'un block' }} the user from logging in.
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="changeUserStatusConfirmDialog = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn tile color="error" @click="updateUserStatus">
                        <v-icon>mdi-content-save-outline</v-icon>
                        Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- assign roles to user dialog form -->
        <v-dialog
            persistent
            max-width="924"
            v-model="addRoleToUserDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    Add role(s)
                </v-card-title>
                <v-divider />
                <v-card-text>
                    <v-form
                        ref="AssignRolesToUserForm"
                    >
                        <v-select
                            :items="systemRoles"
                            item-text="name"
                            item-value="id"
                            v-model="selectedRoles"
                            label="Role"
                            placeholder="Select role"
                            outlined
                            dense
                            multiple
                            persistent-placeholder
                        />
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="addRoleToUserDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn tile color="success" @click="createRoleUser">
                        <v-icon>mdi-content-save-outline</v-icon>
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- re-assign role form a user confirm dialog -->
        <v-dialog
            v-model="reAssignRoleFromUserDialog"
            persistent
            max-width="624"
        >
            <v-card>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    Re-assign role
                </v-card-title>
                <v-card-text>
                    Are you sure you want to re-assign this role from {{ user.name }} ?
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="reAssignRoleFromUserDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        tile
                        color="error"
                        @click="reAssignRoleFromUser"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- new user password dialog -->
        <v-dialog
            persistent
            max-width="924"
            v-model="newUserPasswordDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    New Password
                </v-card-title>
                <v-divider />
                <v-card-text>
                    {{ newPassword }}
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        text
                        @click="newUserPasswordDialog = false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ProgressBar from "@/components/core/ProgressBar";
import commonMixins from "@/mixins/commonMixins";
import API from "@/api";
import checkPermission from "@/utils/permissions";

export default {
    name: "Show",
    props: ['userData'],
    mixins: [commonMixins],
    components: {
        AppLayout,
        ProgressBar
    },

    data(){
        return {
            progressBarVisible: false,
            user: {},
            tab: null,
            userAssignedStoresTableHeaders: [
                {text: 'S/N', value: 'serial_number'},
                {text: 'NAME', value: 'name'},
                {text: 'STATUS', value: 'is_active'},
                {text: 'ACTIONS', value: 'actions'}
            ],
            userAssignedStores: [],
            userAssignedRoles: [],
            userAssignedRolesTableHeaders: [
                {text: 'S/N', value: 'serial_number'},
                {text: 'NAME', value: 'name'},
                {text: 'ACTIONS', value: 'actions'}
            ],
            resetPasswordConfirmDialog: false,
            changeUserStatusConfirmDialog: false,
            selectedRoles: [],
            systemRoles: [],
            addRoleToUserDialog: false,
            reAssignRoleFromUserDialog: false,
            currentRole: {},
            selectedStores: [],
            stores: [],
            currentStore: {},
            addStoreToUserDialog: false,
            removeStoreFromUserDialog: false,
            newUserPasswordDialog: false,
            newPassword: {}
        }
    },

    created() {
        this.processUserData()
        this.getSystemRoles()
    },

    methods: {
        checkPermission,
        processUserData() {
            this.user = this.userData.data
            console.log('process user data')
            console.log(this.user)
            this.userAssignedRoles = this.user.roles
            this.userAssignedRoles.forEach((element, index) => {
                element['serial_number'] = index + 1
            })
        },

        openChangeUserStatusConfirmDialog() {
            this.changeUserStatusConfirmDialog = true
        },

        openResetPasswordConfirmDialog() {
            this.resetPasswordConfirmDialog = true
        },

        openAddRoleToUserDialogForm() {
            this.addRoleToUserDialog = true
        },

        async resetUserPassword() {
            this.progressBarVisible = true

            try {
                const {status, data} = await API.User.recoverUserPassword(this.user.id)
                if (status) {
                    this.progressBarVisible = false
                    this.resetPasswordConfirmDialog = false
                    this.$toast.success("Password reset successfully")
                    this.newPassword = data
                    this.newUserPasswordDialog = true
                }
            } catch (e) {
                this.progressBarVisible = false
                this.$toast.error(e.message)
            }
        },

        async updateUserStatus() {

            this.progressBarVisible = true

            const payload = {is_active: !this.user.is_active}

            try {
                const {status} = await API.User.updateUserStatus(this.user.id, payload)
                if (status) {
                    this.changeUserStatusConfirmDialog = false
                    this.$toast.success("User status updated successfully")
                    window.location.reload()
                }
            } catch (e) {
                this.progressBarVisible = false
                this.$toast.error(e.message)
            }
        },

        async createRoleUser() {
            this.progressBarVisible = true
            if (this.selectedRoles.length === 0) {
                this.$toast.error("Please select at least one role")
                return
            }

            const payload = {
                user_id: this.user.id,
                selectedRoles: this.selectedRoles
            }

            try {
                const {status} = await API.RoleUser.createRoleUser(payload)
                if (status) {
                    this.progressBarVisible = false
                    this.selectedRoles = []
                    this.addRoleToCompanyUserDialog = false
                    this.$toast.success("Role(s) added successfully")
                    window.location.reload()
                }
            } catch (e) {
                this.progressBarVisible = false
                this.$toast.error(e.message)
            }
        },

        async getSystemRoles() {
            const params = {paginate: 'no'}
            const {data} = await API.Role.getRoles(params)
            this.systemRoles = data
        },

        async reAssignRoleFromUser() {
            this.progressBarVisible = true

            try{
                const {status} = await API.RoleUser.deleteRoleUser(this.user.id, this.currentRole.id)
                if (status) {
                    this.progressBarVisible = false
                    this.reAssignRoleFromUserDialog = false
                    this.$toast.success("Role re-assigned successfully")
                    window.location.reload()
                } else {
                    this.progressBarVisible = false
                    this.$toast.error("Something went wrong, please try again")
                }
            } catch (e) {
                this.progressBarVisible = false
                this.$toast.error(e.message)
            }
        },

        openReassignRoleFromUserConfirmDialog(item) {
            this.currentRole = item
            this.reAssignRoleFromUserDialog = true
        },

    }
}
</script>

<style scoped>

</style>
