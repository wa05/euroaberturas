<template>
  <q-layout view="hhh lpR fFf">
<!--    <q-header elevated class="bg-main-green text-white" height-hint="98">-->
<!--      <q-toolbar>-->
<!--        &lt;!&ndash;        <q-btn dense flat round icon="menu" @click="left = !left" />&ndash;&gt;-->
<!--        <q-toolbar-title>-->
<!--          <h4 class="q-ma-xs q-pt-xs text-3 logo">-->
<!--            <i>NexArg</i>-->
<!--          </h4>-->
<!--        </q-toolbar-title>-->
<!--        <q-btn dense flat round icon="menu" color="primary"-->
<!--               v-if="$q.platform.is.mobile" @click="right = !right"/>-->
<!--      </q-toolbar>-->
<!--    </q-header>-->
    <q-drawer
      v-if="$q.platform.is.mobile"
      v-model="right"
      show-if-above
      :width="200"
      :breakpoint="500"
      bordered
      content-class="bg-grey-3"
    >
      <q-scroll-area class="fit">
        <q-list v-for="(menuItem, index) in menuList" :key="index">

          <q-item exact clickable :to="{name: menuItem.route }"
                  :active="menuItem.label === 'Outbox'" v-ripple>
            <q-item-section avatar>
              <q-icon :name="menuItem.icon"/>
            </q-item-section>
            <q-item-section>
              {{ menuItem.label }}
            </q-item-section>
          </q-item>

          <q-separator v-if="menuItem.separator"/>

        </q-list>
      </q-scroll-area>
    </q-drawer>
    <div class="row full-width">
      <!--          <div class="col-xs-12 col-md-12 bg-custom q-pt-xs">-->
      <!--            <h4 class="q-ma-xs text-3 text-center logo">-->
      <!--              <i>NexArg</i>-->
      <!--            </h4>-->
      <!--          </div>-->
      <div class="col-xs-12 col-md-6 offset-md-3">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12"
               :class="{'q-mt-md': $q.platform.is.mobile}">
            <div class="row bg-white">
              <!--                  <q-btn :class="{'active': $route.name === 'home' }"-->
              <!--                         align="center" class="col-xs-6 col-md-3 link" flat block-->
              <!--                         color="secondary" :to="{name:'home'}" label="Inicio"/>-->
              <!--                  <q-btn :class="{'active': $route.name === 'login' }"-->
              <!--                         align="center" class="col-xs-6 col-md-3 link" flat block-->
              <!--                         color="secondary" :to="{name:'login'}" label="Ingresar"/>-->
              <!--                  <q-btn :class="{'active': $route.name === 'register' }"-->
              <!--                         color="secondary" :to="{name:'register'}"-->
              <!--                         align="center" class="col-xs-6 col-md-3 link" flat block-->
              <!--                         label="Registrarse"/>-->
              <!--                  <q-btn :class="{'active': $route.name === 'contact' }"-->
              <!--                         color="secondary" align="center"-->
              <!--                         class="col-xs-6 col-md-3 link" flat block :to="{ name: 'contact' }" label="Contacto"/>-->

            </div>
          </div>
        </div>
        <q-page-container class="GPL__page-container">
          <router-view/>
        </q-page-container>
      </div>
    </div>
  </q-layout>
</template>

<script>
  import {
    openURL,
    QTabs,
    QRouteTab,
    QAvatar,
    QParallax,
  } from "quasar";

  export default {
    name: "PublicLayout",
    components: {
      QParallax,
      QTabs,
      QRouteTab,
      QAvatar,
    },
    data() {
      return {
        menuList: [
          {
            label: 'Inicio',
            icon: 'home',
            route: 'home',
          },
          {
            label: 'Ingresar',
            icon: 'forward',
            route: 'login',
          },
          {
            label: 'Registrarse',
            icon: 'edit',
            route: 'register',
          },
          {
            label: 'Contacto',
            icon: 'mail',
            route: 'contact',
          },
        ],
        right: false,
        leftDrawerOpen: this.$q.platform.is.desktop
      };
    },
    methods: {
      openURL
    }
  };
</script>

<style scoped>
  .link {
    display: block;
    text-align: center;
    /*height:*/
  }


  .bg-white {
    background-color: rgba(255, 255, 255, 0.92) !important;
  }

  .text-center {
    display: block !important;
    text-align: center;
  }

  .q-btn.active {
    color: #499965 !important;
    font-weight: 700;
    border-bottom: 4px solid #499965;
  }

  .logo {
    color: #fff;
    font-size: 2.5rem;
  }
  .q-toolbar {
    min-height: 60px;
  }
  .q-tab {
    min-height: 43px;
  }
  .q-tab {
    padding: 7px 16px;
  }
  .q-layout {
    background: #165751;
  }
  /*.q-layout {*/
  /*  background: url('/statics/fondo3.jpg');*/
  /*  background-repeat: no-repeat;*/
  /*  background-size: cover;*/
  /*  background-position: center center;*/
  /*}*/

  @media (max-width: 480px) {
    .q-layout {
      background-size: auto 100%;
      background-position: left center;
    }
  }
  .main-orange {
    margin: 2px;
    padding: 5px 16px ;
  }
</style>
