<template>
    <app-layout>

        <template v-slot:header>
            Roles
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
                @click="openAddRoleDialog"
                v-if="checkPermission(['create_role'])"
            >
                <v-icon>mdi-plus</v-icon>
                Add Role
            </v-btn>
        </v-toolbar>

        <v-container>
            <v-row>
                <v-col cols="12">

                    <v-text-field
                        append-icon="mdi-magnify"
                        label="Search"
                        placeholder="Search"
                        single-line
                    />

                    <v-card outlined>
                        <v-card-text>
                            <v-data-table
                                :items="roles"
                                :headers="rolesTableHeader"
                                :loading="rolesTableLoading"
                                :server-items-length="serverItemsLength"
                                :items-per-page="itemsPerPage"
                                @update:page="handlePageChanged"
                            >
                                <template #[`item.actions`]="{ item }">
                                    <div class="text-center">
                                        <v-menu offset-y>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn color="primary" text v-bind="attrs" v-on="on">
                                                    <v-icon>mdi-menu</v-icon>
                                                </v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item
                                                    link
                                                    @click="openRolePermissionsDialog(item)"
                                                    v-if="checkPermission(['view_role_details'])"
                                                >
                                                    <v-list-item-title>
                                                        <v-icon>mdi-eye</v-icon>
                                                        View
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

        <!-- role permissions dialog -->
        <v-dialog
            persistent
            max-width="1264"
            v-model="rolePermissionsDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    Edit permissions for {{ currentRole.name }} role
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col cols="12" md="12">
                                <v-autocomplete
                                    v-model="selectedPermissions"
                                    :items="permissions"
                                    chips
                                    clearable
                                    deletable-chips
                                    multiple
                                    small-chips
                                    filled
                                    item-value="id"
                                    item-text="name"
                                    label="Select Permissions"
                                    placeholder="Select permissions to assign to a role"
                                    :loading="permissionsLoading" />
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12">
                                <v-card tile>
                                    <v-toolbar flat>
                                        <v-toolbar-title>
                                            Role Permissions
                                        </v-toolbar-title>
                                    </v-toolbar>
                                    <v-divider />
                                    <v-card-title>
                                        <v-text-field
                                            v-model="searchRolePermissions"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            single-line
                                            hide-details
                                        />
                                    </v-card-title>
                                    <v-card-text>
                                        <v-data-table
                                            :headers="rolePermissionsTableHeader"
                                            :items="rolePermissions"
                                            :items-per-page="10"
                                            :search="searchRolePermissions"
                                            :loading="rolePermissionsTableLoading"
                                        >
                                            <template #[`item.actions`]="{ item }">
                                                <v-btn
                                                    x-small
                                                    text
                                                    outlined
                                                    @click="openRevokePermissionFromRoleDialog(item)"
                                                    v-if="checkPermission(['delete_role_permission'])"
                                                >
                                                    <v-icon text flat color="error">mdi-close</v-icon>
                                                </v-btn>
                                            </template>
                                        </v-data-table>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="closeRolePermissionsDialog"
                    >
                        <v-icon>mdi-close</v-icon>
                        Close
                    </v-btn>
                    <v-btn
                        color="success"
                        @click="updatePermissions"
                        v-if="checkPermission(['create_role_permission'])"
                    >
                        <v-icon>mdi-save</v-icon>
                        Update
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- remove permissions from role confirm dialog -->
        <v-dialog
            v-model="revokePermissionFromRoleDialog"
            persistent
            max-width="624"
        >
            <v-card>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    Revoke permission
                </v-card-title>
                <v-card-text>
                    Are you sure you want to revoke this permission?
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <v-btn color="blue darken-1" text @click="revokePermissionFromRoleDialog = false">
                        Close
                    </v-btn>
                    <v-btn tile color="success" @click="revokePermissionFromRole">
                        <v-icon>mdi-content-save-outline</v-icon>
                        Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- progress bar -->
        <progress-bar :visible="progressBarVisible" />

        <!-- add new role dialog -->
        <v-dialog
            persistent
            max-width="924"
            v-model="AddRoleDialog"
        >
            <v-card>
                <v-card-title
                    class="text-h6 grey lighten-2 mb-3"
                >
                    Add Role
                </v-card-title>
                <v-divider />
                <v-card-text>
                    <validation-observer
                        ref="AddRoleFormValidation"
                    >
                        <v-form ref="AddRoleForm">
                            <validation-provider v-slot="{ errors }" name="name">
                                <v-text-field
                                    v-model="role.name"
                                    label="Role Name"
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
                        text @click="AddRoleDialog=false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        tile
                        color="success"
                        @click="createRole"
                    >
                        <v-icon>mdi-content-save-outline</v-icon>
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import API from '@/api'
import checkPermission from '@/utils/permissions'
import commonMixins from "@/mixins/commonMixins"
import ProgressBar from "@/components/core/ProgressBar"
import { ValidationObserver, ValidationProvider } from "vee-validate"


export default {
    name: "RolesIndex",
    mixins: [commonMixins],
    components: {
        AppLayout,
        ProgressBar,
        ValidationObserver,
        ValidationProvider
    },
    data() {
        return {
            listQuery: {
                page: 1,
                per_page: 10
            },
            rolesTableLoading: false,
            itemsPerPage: null,
            serverItemsLength: null,
            roles: [],
            role: {},
            rolesTableHeader: [
                {text: 'S/N', value: 'index'},
                {text: 'NAME', value: 'name'},
                {text: 'ACTIONS', value: 'actions', align: 'center'}
            ],
            rolePermissionsDialog: false,
            currentRole: {},
            rolePermissionsTableHeader: [
                {text: 'S/N', value: 'index'},
                {text: 'NAME', value: 'name'},
                {text: 'ACTIONS', value: 'actions', align: 'center'}
            ],
            rolePermissions: [],
            permissions: [],
            rolePermissionsTableLoading: false,
            searchRolePermissions: '',
            permissionsLoading: false,
            selectedPermissions: [],
            revokePermissionFromRoleDialog: false,
            currentPermission: {},
            progressBarVisible: false,
            addRolePermissionDialogVisible: false,
            AddRoleDialog: false
        }
    },

    created() {
        this.getRoles()
    },

    methods: {
        checkPermission,
        async getRoles() {
            this.rolesTableLoading = true
            const {data, total, per_page} = await API.Role.getRoles()
            this.roles = data
            this.serverItemsLength = total
            this.itemsPerPage = per_page
            this.roles.forEach((element, index) => {
                element['index'] = (this.listQuery.page -1) * this.listQuery.per_page + index + 1
            })
            this.rolesTableLoading = false
        },

        handlePageChanged(page) {
            this.listQuery.page = page
            this.getRoles()
        },

        openRolePermissionsDialog(item) {
            this.permissions = []
            this.rolePermissionsDialog = true
            this.currentRole = item
            this.getPermissions()
            this.getRolePermissions()
        },

        async getPermissions() {
            this.permissions = []
            this.permissionsLoading = true
            const payload = {paginate: 'no'}
            const { data } = await API.Permission.getPermissions(payload);
            this.permissions = data
            // data.forEach((permission) => {
            //     this.permissions.push({
            //         text: permission.name,
            //         value: permission.id,
            //         disabled: this.checkIfRoleHasPermission(permission.id),
            //     })
            // });
            this.permissionsLoading = false
        },

        async getRolePermissions(){
            this.rolePermissionsTableLoading = true
            this.rolePermissions = await API.RolePermission.getRolePermissions(this.currentRole.id)
            this.rolePermissions.forEach((element, index) => {
                element['index'] = (this.listQuery.page - 1) * this.listQuery.per_page + index +1
            })
            this.rolePermissionsTableLoading = false
        },

        checkIfRoleHasPermission(permissionId) {
            const found = this.rolePermissions.find(permission => permission.id === permissionId);
            return found !== undefined;
        },

        closeRolePermissionsDialog() {
            this.permissions = []
            this.rolePermissionsDialog = false
        },

        async updatePermissions() {

            this.progressBarVisible = true

            if(this.selectedPermissions.length > 0) {
                const { status, statusCode } = await API.RolePermission.updateRolePermissions(
                    this.currentRole.id,
                    {permissions: this.selectedPermissions}
                )
                if (!status && statusCode === 404) {
                    this.progressBarVisible = false
                    this.$toast.error('Role not found')
                } else {
                    this.progressBarVisible = false
                    this.$toast.success('Permissions updated successfully')
                    this.permissions = []
                    await this.getRolePermissions()
                    await this.getPermissions()
                }
            } else {
                this.progressBarVisible = false
                this.$toast.error('Please select at least one permission')
            }
        },

        openRevokePermissionFromRoleDialog(item) {
            this.currentPermission = item
            this.revokePermissionFromRoleDialog = true
        },

        async revokePermissionFromRole(){

            this.progressBarVisible = true

            const { status } = await API.RolePermission.revokePermissionFromRole(
                this.currentPermission.id,
                this.currentRole.id
            )

            if(status) {
                this.progressBarVisible = false
                this.$toast.success('Permission revoked successfully')
                this.revokePermissionFromRoleDialog = false
                await this.getRolePermissions()
                await this.getPermissions()
            }
        },

        openAddRoleDialog() {
            this.AddRoleDialog = true
        },

        async createRole() {

            console.log('createRole')
            this.progressBarVisible = true

            try {
                const {error, message} = await API.Role.createRole(this.role)
                if (error) {
                    this.progressBarVisible = false
                    this.$refs.AddRoleFormValidation.setErrors(message)
                } else {
                    this.progressBarVisible = false
                    this.AddRoleDialog = false
                    this.$toast.success(message)
                }
            } catch (e) {
                this.progressBarVisible = false
                this.$toast.error(e.message)
            }
        }
    }
}
</script>

<style scoped>

</style>
