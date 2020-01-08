<template>
  <q-layout view="hHh lpR fFf">
    <q-header v-if="$q.platform.is.mobile"
        elevated class="bg-white text-white" height-hint="98">
      <q-toolbar>
        <q-btn dense flat round icon="menu" color="primary"
               @click="leftDrawerOpen = !leftDrawerOpen"/>
        <q-toolbar-title>
          <img src="statics/logoeuro.png" height="40px" alt="">
        </q-toolbar-title>
        <!--  <q-btn dense flat round icon="menu" color="primary"
                v-if="$q.platform.is.mobile" @click="right = !right"/> -->
      </q-toolbar>
    </q-header>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-primary"
      :width="240"
    >
      <q-scroll-area class="fit">
        <q-list padding>
          <q-toolbar-title v-if="!$q.platform.is.mobile"
                           class="bg-white q-pa-md text-center">
            <img src="statics/logoeuro.png" height="40px" alt="">
          </q-toolbar-title>
          <q-item-label header class="text-weight-bold text-uppercase">
          </q-item-label>

          <span v-for="link in links1" :key="link.text">
              <q-item
                v-if="!link.childrens.length"
                v-ripple clickable
                active-class="bg-secondary"
                exact
                :to="{ name: link.route }">
                <q-item-section avatar>
                  <q-icon color="white" :name="link.icon"/>
                </q-item-section>
                <q-item-section>
                  <q-item-label>{{ link.text }}</q-item-label>
                </q-item-section>
              </q-item>

              <q-expansion-item
                v-if="link.childrens.length"
                :key="link.text"
                :default-opened="false"
                expand-separator
                class="text-white"
                :icon="link.icon"
                :label="link.text"
              >
<!--                :caption="item.caption"-->
                <q-item
                  v-for="children in link.childrens"
                  :key="children.route"
                  class="q-pl-md bg-tertiary"
                  color="primary"
                  active-class="bg-secondary"
                  tag="a"
                  :to="{ name: children.route }">
                  <q-item-section avatar>
                    <q-icon color="white" :name="children.icon" />
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>
                      <span v-text="children.text"></span>
                    </q-item-label>
                    <q-item-label caption></q-item-label>
                  </q-item-section>
                </q-item>
            </q-expansion-item>
          </span>

          <q-separator class="q-my-md"/>

          <q-item v-for="link in links4"
                  active-class="bg-secondary"
                  @click="logout()"
                  :key="link.text"
                  color="white"
                  class="text-white"
                  v-ripple clickable>
            <q-item-section avatar>
              <q-icon color="white" :name="link.icon"/>
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ link.text }}</q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container class="GPL__page-container">
      <router-view/>
    </q-page-container>

    <q-dialog
      v-model="showModal"
    >
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section>
          <div class="text-center">
            <a class="logoa logom" href="#" style="padding-left: 10px !important;">
              <span class="block q-pa-md logo"><i></i></span>
            </a>
          </div>
        </q-card-section>

        <q-card-actions align="right" class="bg-white text-teal">
          <q-btn flat label="Continuar" v-close-popup/>
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script>
  import {
    QScrollArea,
    QSeparator,
    QExpansionItem,
  } from 'quasar'

  export default {
    components: {
      QScrollArea,
      QSeparator,
      QExpansionItem,
    },
    name: 'AuthLayout',
    data() {
      return {
        left: false,
        right: false,
        showModal: false,
        leftDrawerOpen: false,
        search: '',
        links4: [
          {
            icon: 'logout',
            text: 'Salir'
          },
        ],
        storage: 0.26,
        links1: [
          {
            icon: 'home',
            text: 'Inicio',
            route: 'dashboard',
            childrens: []
          },
          {
            icon: 'shop',
            text: 'Presupuestos',
            route: 'budgets-list',
            childrens: []
          },
          {
            icon: 'account_box',
            text: 'Clientes',
            route: 'clients-list',
            childrens: []
          },
          {
            icon: 'fiber_new',
            text: 'Productos / Servicios',
            // route: 'publish-service',
            childrens: [
              {
                icon: 'create_new_folder',
                text: 'Listado productos',
                route: 'products-list'
              },
              {
                icon: 'create_new_folder',
                text: 'Listado servicios',
                route: 'services-list'
              },

              // {
              //   icon: 'search',
              //   text: 'Categorías',
              //   route: 'product-categories'
              // },
            ]
          },
        ],

      }
    },
    watch: {
      search(newVal, oldVal) {
        this.$events.fire('changed', newVal)
      }
    }
    ,
    mounted() {
      this.initView()
    }
    ,
    methods: {
      initView() {
        this.showModal = false
        // this.loading = true
      }
      ,
      logout() {
        this.$auth.logout({
          redirect: {
            name: 'login'
          }
        });
      }
      ,
      color(route) {
        let defaultColour = 'white'
        if (this.$route.name === route) {
          defaultColour = 'white'
        }
        return defaultColour
      }
    }
  }
</script>

<style scoped lang="stylus">
  .GPL
    &__toolbar
      height 64px

    &__toolbar-input
      width 35%

    &__drawer-item
      line-height 24px
      border-radius 0 24px 24px 0
      margin-right 12px

      .q-item__section--avatar
        padding-left 12px

        .q-icon
          color #5f6368

      .q-item__label:not(.q-item__label--caption)
        color #3c4043
        letter-spacing .01785714em
        font-size .875rem
        font-weight 500
        line-height 1.25rem

      &--storage
        border-radius 0
        margin-right 0
        padding-top 24px
        padding-bottom 24px

    &__side-btn
      &__label
        font-size 12px
        line-height 24px
        letter-spacing .01785714em
        font-weight 500
    @media (min-width 1024px)
      &__page-container
        padding-left 94px

  .q-pt-xl, .q-py-xl {
    padding-top: 48px;
    background: #f2f3f2;
  }
    .logo {
      color: #fff;
    }
  .logoa {
    padding-left: 40px;
    font-size: 30px;
    color: #f57b6c;
    text-decoration: none;
  }

  .logom {
    padding-left: 4px;
  }

  .fit {
    overflow-y: hidden;
  }

  /*.q-layout {*/
  /*  background: url('../statics/bg4.png');*/
  /*  background-repeat: no-repeat;*/
  /*  background-size: cover;*/
  /*}*/
  .q-layout {
    /*background: #f6f7fc;*/
    background: #ebebee;
  }
</style>
