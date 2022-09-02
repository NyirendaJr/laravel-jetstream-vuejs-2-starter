import request from "@/utils/request";


export function createUserPermissions(userId, permissions) {
    return request({
        url: `/admin/user-permissions/update-user-permissions/${userId}`,
        method: "put",
        data: permissions
    });
}

export function deleteUserPermissions(userId, permissionId) {
    return request({
        url: `/admin/user-permissions/revoke-user-permission/${userId}/${permissionId}`,
        method: "delete"
    });
}
