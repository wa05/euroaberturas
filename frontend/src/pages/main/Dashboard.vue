<template>
  <div class="row relative q-pa-sm">
    <div class="col-xs-12">
      <q-card class="bg-white">
        <q-card-section>
          <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
              <div class="q-card q-ma-md q-pa-xs text-center bg-tertiary text-white">
                Mis publicaciones
              </div>
              <h3 class="text-center text-tertiary bolder q-ma-xs">
                4
              </h3>
            </div>
            <div class="col-md-3">
              <div class="q-card q-ma-md q-pa-xs text-center bg-tertiary text-white">
                Servicios en 300km
              </div>
              <h3 class="text-center text-tertiary bolder q-ma-xs">
                6
              </h3>
              <!--             <img src="statics/tractor-6125d-landing.png" class="img-fluid truck" alt="">-->
            </div>
            <div class="col-md-3">
              <div class="q-card q-ma-md q-pa-xs text-center bg-tertiary text-white">
                Visitas a mis servicios
              </div>
              <h3 class="text-center text-tertiary bolder q-ma-xs">
                18
              </h3>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>
  import {QRating, QBadge} from 'quasar'
  import {mapGetters, mapActions} from 'vuex'

  export default {
    components: {
      QRating,
      QBadge
    },
    data() {
      return {
        moreParams: {
          type: 'service'
        }
      }
    },
    mounted() {
      this.initView()
    },
    computed: {
      ...mapGetters({
        'homeServices': 'services/homeServices'
      }),
      appPath() {
        return process.env.API_URL
      },
    },
    methods: {
      reload(type) {
        this.moreParams.type = type
        this.getHomeServices(this.moreParams)
      },
      ...mapActions({
        'getHomeServices': 'services/getHomeServices'
      }),
      imageUrl(service) {
        let name = 'statics/default-truck.png'
        if (service.starred && service.starred.name) {
          name = `${this.appPath}/img/users/${service.user_id}/${service.starred.name}`
        }
        return name
      },
      initView() {
        // this.getHomeServices(this.moreParams)
      },
      redirect(serviceId) {
        this.$router.push({name: 'publication-detail', params: {id: serviceId}})
      }
    },
    events: {}
  }
</script>

<style scoped>
  .full-width {
    left: 10px;
    top: 40px;
  }

  .min55 {
    min-height: 55px;
  }

  .main-card {
    cursor: pointer;
  }
  .q-badge:hover {
    cursor: pointer;
    color: white!important;
    background: #e49e9f!important;
  }
  .truck {
    max-height: 140px;
  }
  .text-teal {
    color: #e49e9f!important;
  }
  .bg-teal {
    background: #e49e9f!important;
  }

</style>
