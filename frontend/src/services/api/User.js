import baseApi from '../BaseApi';

export default {
    async register(params = {}) {
        return await baseApi.post('api/v1/register', params)
    }
}
