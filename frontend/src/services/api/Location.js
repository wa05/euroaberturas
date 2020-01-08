import baseApi from '../BaseApi';

export default {
  async getProvinces(params = {}) {
    return await baseApi.post('api/v1/locations/get-provinces', params)
  },
  async getDepartments(params) {
    return await baseApi.post('api/v1/locations/get-departments', params)
  },
  async getCities(params) {
    return await baseApi.post('api/v1/locations/get-cities', params)
  },
}
