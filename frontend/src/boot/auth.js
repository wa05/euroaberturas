/* eslint no-unused-vars: ["error", { "args": "none" }] */

// import something here
const authBase = require('@websanova/vue-auth');
const authVar = require('@websanova/vue-auth/drivers/auth/laravel-passport-bearer.js');
const httpVar = require('@websanova/vue-auth/drivers/http/axios.1.x.js');
const routerVar = require('@websanova/vue-auth/drivers/router/vue-router.2.x.js');

// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  Vue.router = router;
  Vue.use(authBase, {
    auth: authVar,
    http: httpVar,
    router: routerVar,

    authRedirect: '/',
    fetchData: {
      url: `${process.env.API_URL}/api/v1/user`,
      method: 'GET',
      enabled: true,
      success(resp) {
        Vue.prototype.$auth.user(resp.data)
      }
    },
    refreshData: {
      url: `${process.env.API_URL}/oauth/token`,
      method: 'POST',
      enabled: true,
      interval: 30,
      checkExpiration: true,
      success(resp) {
        Vue.prototype.$auth.user(resp.data)
      },
      catch(e) {
        debugger
      }
    },

    passportData: {
      client_id: process.env.CLIENT_ID,
      client_secret: process.env.CLIENT_SECRET,
    }
  });
};
