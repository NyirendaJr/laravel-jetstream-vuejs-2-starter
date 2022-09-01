import request from "@/utils/request"


export function createRoleUser(data) {
    return request({
        url: '/admin/role-users',
        method: 'post',
        data: data
    })
}


export function deleteRoleUser(userId, roleId) {
    return request({
        url: `/admin/role-users/${userId}/${roleId}`,
        method: 'delete',
    })
}
