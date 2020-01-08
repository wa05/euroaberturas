<template>
  <q-page>
    <div class="row">
      <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
               col-md-8 offset-md-2 q-pa-xs">
        <q-card class="bg-white">
          <q-card-section>
            <div class="col-xs-12 text-center">
              <strong class="advise">Ingrese email para recuperar su contraseña</strong> <br>
              Recibirá un mail con instrucciones
            </div>
            <q-form
              @submit="onSubmit"
              class="q-gutter-md q-mt-md q-pa-sm"
            >
              <div class="text-center">
                <q-input v-model="form.email"
                         placeholder="Ingrese email" filled
                         type="email" hint="Email con el que se registró previamente"/>
                <q-btn color="primary" type="submit" block
                       label="Recuperar" class="q-mt-md full-width"></q-btn>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>

</template>

<script>
  import {
    QInput,
    QCard,
    QField,
    QForm,
    QBtn,
    QToggle,
    QIcon,
    QParallax,
    QCardActions,
    QCardSection
  } from 'quasar'

  export default {
    name: 'Login',
    components: {
      QInput,
      QCard,
      QField,
      QForm,
      QToggle,
      QIcon,
      QParallax,
      QBtn,
      QCardActions,
      QCardSection
    },
    mixins: [],
    data() {
      return {
        isPwd: true,
        error: '',
        form: {
          email: '',
        },
        loading: false,
      }
    },
    mounted() {
      // console.log('Dotenv Test', process.env)
    },
    methods: {
      async onSubmit() {
        this.error = ''
        try {
          this.loading = true

        } catch (e) {
        } finally {
          this.loading = false
        }
      },
      onReset() {

      }
    }
  }
</script>

<style scoped>
  .q-card {
    border: none;
    border-radius: none;
  }
</style>
