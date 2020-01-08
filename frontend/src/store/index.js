import Vue from "vue";
import Vuex from "vuex";

import serviceCategories from './serviceCategories'
import services from './services'
import brands from './brands'
import publications from './publications'
import locations from './locations'

Vue.use(Vuex);

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function(/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
    	serviceCategories,
      services,
      brands,
      publications,
      locations
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  });

  return Store;
}
