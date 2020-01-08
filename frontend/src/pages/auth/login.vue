<template>
  <q-page class="flex flex-center">
    <div class="row">
      <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
               col-md-12 q-pa-xs">
        <q-card class="bg-white">
          <q-card-section>
            <div class="col-xs-12 text-center">
              <img src="statics/logoeuro.png" class="img-fluid logo" alt="">
              <br>
              <strong class="advise">Ingrese datos de acceso</strong> <br><br>
            </div>
            <q-form
              @submit="onSubmit"
              class="q-gutter-md"
            >
              <q-input v-model="form.email"
                       placeholder="Ingrese su email" filled
                       type="email" hint="Email"/>
              <q-input v-model="form.password"
                       placeholder="Ingrese su contraseña"
                       filled type="password" hint="Contraseña"/>

              <div v-if="error != ''"
                   class="bg-negative text-center white-color q-pa-sm">
                <span v-text="error"></span>
              </div>
              <div class="text-center">
                <!-- <q-btn label="Cancelar" type="reset" color="primary" flat class="q-ml-sm" /> -->
                <q-btn class="full-width" label="Iniciar sesión"
                       :loading="loading"
                       type="submit" color="primary"/>
                <br>
                <!-- <a align="left" flat round label=""  /> -->
              </div>
            </q-form>

          </q-card-section>
          <q-card-actions align="around">
            <!--          <a align="right" class="link" href="registrarse">Registrarse</a>-->
            <!-- <q-btn align="right" flat round label="Registrarse" /> -->
            <q-btn flat align="center" :to="{ name: 'recover-password'}" size="sm"
                   color="primary" label="Olvidaste tu contraseña ?"></q-btn>
          </q-card-actions>
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
    QToggle,
    QIcon,
    QParallax,
    QCardActions,
    QCardSection,
    QBtn,
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
          email: 'admin@euroaberturas.com',
          password: 'secret123',
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
          await this.$auth.login({
            url: `${process.env.API_URL}/oauth/token`,
            data: {username: this.form.email, password: this.form.password},
            rememberMe: true,
            redirect: {name: 'dashboard'},
            fetchUser: true
          });
        } catch (e) {
          this.error = 'Credenciales incorrectas'
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
  .logo {
    margin: 20px 30px;
    max-width: 300px;
  }
</style>
