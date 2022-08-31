import request from "@/utils/request";


export function getRolePermissions(roleId) {
    return request({
        url: `/admin/role-permissions/${roleId}`,
        method: 'get'
    })
}

export function updateRolePermissions(permissions, roleId) {
    return request({
        url: `/admin/role-permissions/update-role-permissions/${roleId}`,
        method: 'put',
        data: permissions
    })
}

export function revokePermissionFromRole(permissionId, roleId) {
    return request({
        url: `/admin/role-permissions/revoke-role-permission/${permissionId}/${roleId}`,
        method: 'delete'
    })
}
