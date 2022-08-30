import request from '@/utils/request'

export function getPermissions(query) {
    return request({
        url: '/admin/permissions',
        method: 'get',
        params: query,
    })
}

export function syncPermissions() {
    return request({
        url: '/admin/sync-permissions',
        method: 'get',
    })
}

export function updatePermissions(data, id) {
    return request({
        url: `/admin/permissions/${id}`,
        method: 'put',
        data: data
    })
}
