import request from "@/utils/request";


export function getUsers(params) {
    return request({
        url: '/admin/users',
        method: 'get',
        params: params
    })
}

export function createUser(data) {
    return request({
        url: '/admin/users',
        method: 'post',
        data: data
    })
}


export function updateProfileInformation(data) {
    return request({
        url: '/user/profile-information',
        method: 'put',
        data: data
    })
}

export function updateUser(id, data) {
    return request({
        url: `/admin/users/${id}`,
        method: 'put',
        data: data
    })
}


export function recoverUserPassword(id) {
    return request({
        url: `/admin/recover-user-password/${id}`,
        method: 'put',
    })
}

export function updateUserStatus(id, data) {
    return request({
        url: `/admin/block-user/${id}`,
        method: 'put',
        data: data
    })
}
