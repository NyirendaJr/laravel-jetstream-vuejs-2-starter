export const routes = [
    {
        path: '/admin',
        name: 'admin',
        meta: {
            title: 'admin',
            icon: 'mdi-application-settings',
            permissions: ['view menu admin']
        },
        children: [
            {
                path: '/admin/permissions',
                name: 'admin.permissions.index',
                meta: {
                    title: 'permissionsIndex',
                    permissions: ['view menu permissions'],
                },
            },
            {
                path: '/admin/roles',
                name: 'admin.roles.index',
                meta: {
                    title: 'rolesIndex',
                    permissions: ['view menu roles'],
                },
            },
            {
                path: '/admin/users',
                name: 'admin.users.index',
                meta: {
                    title: 'adminUsersIndex',
                    permissions: ['view menu users']
                }
            },
        ]
    },
]
