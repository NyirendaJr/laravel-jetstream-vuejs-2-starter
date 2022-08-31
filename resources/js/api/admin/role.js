import request from '@/utils/request'


export function getRoles(params) {
    return request({
        url: '/admin/roles',
        method: 'get',
        params: params
    })
}
