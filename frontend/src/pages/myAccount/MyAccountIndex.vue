<template>
  <div class="row q-pa-lg">
    <div class="col-xs-12 col-md-10 offset-md-1">
      <h6 class="q-ma-xs q-mb-sm text-primary bolder">
        Mi cuenta
      </h6>
      <q-card>
        <q-card-section>
          <q-form
            @submit="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
          >
            <div class="row">
              <div class="col-xs-12 text-center q-mb-xs">
                <br>
                <!--                 <strong class="advise">
                                  <a href="mailto:info@nexarg.com.ar">info@nexarg.com.ar</a>
                                </strong> -->
                <q-form>
                  <div class="row">
                    <div class="col-xs-12 col-md-6 q-pa-xs">
                      <q-input label="Nombre de usuario" v-model="form.name"></q-input>
                    </div>
                    <div class="col-xs-12 col-md-6  q-pa-xs">
                      <q-input label="Apellido" v-model="form.last_name"></q-input>
                    </div>
                    <div class="col-xs-12 col-md-6  q-pa-xs">
                      <q-input label="Teléfono" v-model="form.phone"></q-input>
                    </div>
                    <div class="col-xs-12 col-md-6  q-pa-xs">
                      <q-input type="email" label="Email" disable v-model="form.email"></q-input>
                    </div>
                  </div>
                  <div class="row q-mt-md">
                    <div class="col-xs-12 col-md-12 text-center">
                      <q-btn label="Guardar cambios" color="primary"></q-btn>
                    </div>
                  </div>
                </q-form>
              </div>
            </div>
          </q-form>
        </q-card-section>
        <q-card-actions align="around">
        </q-card-actions>
      </q-card>
    </div>
  </div>
</template>

<script>
  import {
    QInput,
    QCard,
    // QField,
    QForm,
    QToggle,
    QCardActions,
    QCardSection,
    QParallax,
    QIcon,
    QDialog,
  } from 'quasar'

  const {required, minLength} = require('vuelidate/lib/validators')
  import userApi from '../../services/api/User'

  export default {
    components: {
      QInput,
      QCard,
      // QField,
      QForm,
      QToggle,
      QCardActions,
      QCardSection,
      QParallax,
      QIcon,
      QDialog,
    },
    props: {},
    data() {
      return {
        isPwd: true,
        form: {
          name: null,
          last_name: null,
          phone: null,
          address: null,
          email: null,
          accept: false,
        },
        alert: false,
      }
    },
    validations: {
      form: {
        name: required,
        last_name: required,
        email: required,
        password: {
          required,
          minLength: minLength(8)
        },
        password_confirmation: {
          required,
          minLength: minLength(8)
        },
      }
    },
    mounted() {
      this.initView()
    },
    methods: {
      initView() {
        this.getUserData()
      },
      async getUserData() {
        try {
          this.$q.loading.show()
          const resp = await this.$axios.get('api/v1/user')
          this.form.name = resp.data.name
          this.form.last_name = resp.data.last_name
          this.form.email = resp.data.email
          this.form.phone = resp.data.phone
        } catch (e) {

        } finally {
          this.$q.loading.hide()
        }
      },
      async onSubmit() {
        try {
          this.loading = true
          this.$v.form.$touch()
          if (!this.$v.form.$error) {
            // const resp = await userApi.register(this.form)
            debugger
            if (!resp.error) {
              this.alert = true
            }
          }
          this.loading = false
        } catch (e) {
          this.loading = false
        }
      },
      onReset() {

      }
    },
    events: {}
  }
</script>

<style scoped>
  .q-field--with-bottom {
    padding-bottom: 0px;
  }
</style>
