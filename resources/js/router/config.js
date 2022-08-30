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
                name: 'permissions.index',
                meta: {
                    title: 'permissionsIndex',
                    permissions: ['view menu permissions'],
                },
            },
            {
                path: '/admin/roles',
                name: 'roles.index',
                meta: {
                    title: 'rolesIndex',
                    permissions: ['view menu roles'],
                },
            },
            {
                path: '/admin/users',
                name: 'users.index',
                meta: {
                    title: 'adminUsersIndex',
                    permissions: ['view menu users']
                }
            },
        ]
    },
]
