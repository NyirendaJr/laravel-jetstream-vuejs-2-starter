
<template>
    <app-layout>

        <template v-slot:header>
            Permissions
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
                @click="openSyncPermissionsDialog"
            >
                <v-icon>mdi-refresh</v-icon>
                Sync permissions
            </v-btn>
        </v-toolbar>

        <v-container>
            <v-row>
                <v-col cols="12">

                    <v-text-field
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        placeholder="Search..."
                    />

                    <v-card outlined>
                        <v-card-text>
                            <v-data-table
                                :loading="permissionsTableLoading"
                                :headers="permissionsTableHeaders"
                                :items="permissions"
                                :items-per-page-options="[10, 15, 30, 50]"
                                :server-items-length="serverItemsLength"
                                :items-per-page="itemsPerPage"
                                @update:page="handlePageChanged"
                                @update:items-per-page="handleItemsPerPageChange"
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
                                                    @click="openEditPermissionDialog(item)"
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

        <!-- sync permissions dialog -->
        <v-dialog
            v-model="syncPermissionsDialog"
            persistent
            max-width="624px"
        >
            <v-card>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    Permissions sync confirmation
                </v-card-title>
                <v-card-text>
                    Are you sure you want to sync permissions?
                </v-card-text>
                <v-divider />
                <v-card-actions>
                    <v-spacer />
                    <v-btn @click="syncPermissionsDialog = false">
                        Cancel
                    </v-btn>
                    <v-btn color="red darken-1" dark @click="syncPermissions">
                        Confirm
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--- progress bar dialog -->
        <progress-bar :visible="progressBar" />

        <!-- edit permission dialog -->
        <v-dialog
            v-model="editPermissionDialogFormVisible"
            max-width="924"
            persistent
        >
            <v-card flat>
                <v-card-title class="text-h6 grey lighten-2 mb-3">
                    Edit permission
                </v-card-title>

                <v-card-text>
                    <ValidationObserver ref="editPermissionFormValidation">
                        <v-form ref="editPermissionForm">
                            <ValidationProvider v-slot="{ errors }" vid="name" name="Name">
                                <v-text-field
                                    :error-messages="errors[0]"
                                    v-model="permission.name"
                                    label="Title"
                                    placeholder="Enter expenditure title"
                                    autocomplete="off"
                                    outlined
                                    dense
                                    disabled
                                />
                            </ValidationProvider>

                            <validation-provider v-slot="{ errors }" name="description">
                                <v-textarea
                                    :error-messages="errors[0]"
                                    v-model="permission.description"
                                    label="Description"
                                    autocomplete="off"
                                    outlined
                                    dense
                                />
                            </validation-provider>
                        </v-form>
                    </ValidationObserver>
                </v-card-text>

                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="editPermissionDialogFormVisible = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        tile
                        color="success"
                        @click="updatePermission"
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
const ProgressBar = () => import('@/components/core/ProgressBar')
import API from '@/api'
import commonMixins from "@/mixins/commonMixins";
import checkPermission from "@/utils/permissions";
import { ValidationProvider, ValidationObserver } from 'vee-validate'

export default {
    name: "PermissionsIndex",
    mixins: [commonMixins],
    components: {
        AppLayout,
        ProgressBar,
        ValidationObserver,
        ValidationProvider
    },
    data() {
        return {
            permissionsTableLoading: false,
            permissionsTableHeaders: [
                {text: 'S/N', value: 'index'},
                {text: 'NAME', align: 'start', sortable: false, value: 'name'},
                {text: 'DESCRIPTION', value: 'description'},
                {text: 'ACTIONS', value: 'actions', align: 'center'}
            ],
            permissions: [],
            permission: {},
            serverItemsLength: null,
            itemsPerPage: null,
            syncPermissionsDialog: false,
            progressBar: false,
            listQuery: {
                page: 1,
                per_page: 10
            },
            editPermissionDialogFormVisible: false,
            currentPermission: {},
            progressBarVisible: false
        }
    },

    created() {
        this.getPermissions();
    },

    methods: {
        checkPermission,
        handlePageChanged(page) {
            this.listQuery.page = page
            this.getPermissions()
        },

        handleItemsPerPageChange(itemsPerPage) {
            this.listQuery.per_page = itemsPerPage
            this.getPermissions()
        },

        async getPermissions() {
            this.permissionsTableLoading = true
            const response = await API.Permission.getPermissions(this.listQuery)
            const { data, total, per_page } = response.data
            console.log(response)
            this.permissions = data
            this.permissions.forEach((element, index) => {
                element['index'] = (this.listQuery.page - 1) * this.listQuery.per_page + index + 1;
            })
            this.serverItemsLength = total
            this.itemsPerPage = per_page
            this.permissionsTableLoading = false
        },

        openSyncPermissionsDialog() {
            this.syncPermissionsDialog = true;
        },

        async syncPermissions() {
            this.progressBar = true
            const {status} =  await API.Permission.syncPermissions()
            if (status) {
                this.progressBar = false
                this.syncPermissionsDialog = false
                this.$toast.success('Permissions synced successfully')
            } else {
                this.progressBar = false
                this.syncPermissionsDialog = false
                this.$toast.error('Something went wrong')
            }
            this.progressBar = false
            await this.getPermissions()
        },

        async updatePermission() {
            this.progressBarVisible = true

            try {
                const { error, message } = await API.Permission.updatePermissions(this.permission, this.currentPermission.id)
                if(error) {
                    this.progressBarVisible = false
                    this.$refs.editPermissionFormValidation.setErrors(message)
                } else {
                    this.progressBarVisible = false
                    this.editPermissionDialogFormVisible = false
                    this.$toast.success(message)
                    await this.getPermissions()
                }
            } catch (e) {
                this.progressBarVisible = false
            }

        },

        openEditPermissionDialog(item) {
            this.permission = {}
            this.currentPermission = item
            this.permission.name = this.currentPermission.name
            this.permission.description = this.currentPermission.description
            this.editPermissionDialogFormVisible = true
        }
    }
}
</script>

