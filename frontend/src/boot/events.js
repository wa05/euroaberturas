import VueEvents from 'vue-events';

export default ({ Vue }) => {
  // Vue.prototype.$events = VueEvents;
  Vue.use(VueEvents);
};
