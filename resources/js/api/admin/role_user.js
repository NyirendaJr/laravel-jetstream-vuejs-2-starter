import request from "@/utils/request"


export function createRoleUser(data) {
    return request({
        url: '/app/role-users',
        method: 'post',
        data: data
    })
}


export function deleteRoleUser(userId, roleId) {
    return request({
        url: `/app/role-users/${userId}/${roleId}`,
        method: 'delete',
    })
}
