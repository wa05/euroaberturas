import baseApi from '../BaseApi';

export default {
  async catsForSelect(params) {
    const resp = await baseApi.post('api/v1/service-categories/for-select', params)
    return resp;
  },
  async subcatsForSelect(params) {
    const resp = await baseApi.post('api/v1/service-sub-categories/for-select', params)
    return resp;
  }
}
