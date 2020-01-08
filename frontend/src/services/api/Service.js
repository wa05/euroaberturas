import baseApi from '../BaseApi';

export default {
  async create(params = {}) {
    debugger
    return await baseApi.post('api/v1/services/resource', params)
  },
  async myServices(params) {
    return await baseApi.post('api/v1/services/my-services', params)
  },
  async getHomeServices(params = {}) {
    const resp = await baseApi.get('api/v1/services/resource', params)

    return resp
  },
  async getPublicationDetail(params = {}) {
    const resp = await baseApi.get(`api/v1/services/resource/${params.serviceId}`)
    return resp
  },
  async deleteService(serviceId) {
    const resp = await baseApi.delete(`api/v1/services/resource/${serviceId}`)
    return resp
  },
  async requestService(params) {
    const resp = await baseApi.post('api/v1/services/request,service', params )
    return resp
  },
}
