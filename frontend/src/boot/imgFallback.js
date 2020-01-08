// import something here
import VueImgFallback from 'v-img-fallback';

// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  Vue.use(VueImgFallback, {
	  loading: 'statics/vaquita.jpg',
	  error: 'statics/vaquita.jpg'
	});
}
