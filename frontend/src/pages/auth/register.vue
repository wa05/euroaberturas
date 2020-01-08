<template>
  <q-page>
    <div class="row">
      <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
               col-md-10 offset-md-1 q-pa-xs">
        <q-card class="bg-white">
          <q-card-section>
            <q-form
              @submit="onSubmit"
              @reset="onReset"
              class="q-gutter-md"
            >
              <div class="row">
                <div class="col-xs-12 text-center">
                  <strong class="advise">Complete formulario para registrarse</strong> <br><br>
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                        col-sm-6 col-md-6 q-pa-xs">
                  <q-input dense
                           filled
                           v-model="form.name"
                           :error="$v.form.name.$error"
                           label="Ingresar nombre *"
                           lazy-rules
                           :rules="[ val => val && val.length > 0 || 'Por favor ingrese su nombre']"
                  />
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                col-sm-6 col-md-6 q-pa-xs">
                  <q-input dense
                           filled
                           v-model="form.last_name"
                           :error="$v.form.last_name.$error"
                           label="Ingrese su apellido *"
                           lazy-rules
                           :rules="[
                  val => val !== null && val !== '' || 'Ingrese su apellido'
                ]"
                  />
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                      col-sm-6 q-pa-xs">
                  <q-input dense v-model="form.email"
                           :error="$v.form.email.$error"
                           label="Ingrese su email *"
                           filled type="email"/>
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                    col-sm-6 col-md-6 q-pa-xs">
                  <q-input dense v-model="form.password"
                           :error="$v.form.password.$error"
                           filled type="password" label="Contraseña *"/>
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                        col-sm-6 col-md-6 q-mt-xs q-pl-xs">
                  <q-input dense v-model="form.password_confirmation" filled
                           :error="$v.form.password_confirmation.$error"
                           :type="isPwd ? 'password' : 'text'" label="Repetir contraseña *">
                    <template v-slot:append>
                      <q-icon
                        :name="isPwd ? 'visibility_off' : 'visibility'"
                        class="cursor-pointer"
                        @click="isPwd = !isPwd"
                      />
                    </template>
                  </q-input>
                </div>
                <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0
                        col-sm-6 q-pa-xs">
                  <q-input dense v-model="form.phone"
                           filled type="tel" label="Número de teléfono"/>
                </div>
                <div class="col-md-12 text-center">
                  <q-btn label="Ver términos y condiciones" flat color="primary" 
                        @click="showTerms = true"/>  
                </div>
              </div>
              <div class="q-pa-xs">
                <q-btn class="full-width" :disabled="!form.accept"
                       label="Registrarse" type="submit" color="primary"/>
              </div>
            </q-form>
          </q-card-section>
          <q-card-actions align="around">
            <!--          <a align="right" class="link" href="ingresar">Ya soy usuario</a>-->
            <!-- <q-btn align="right" flat round label="Registrarse" /> -->
            <a align="cente" class="link" href="#">Olvidaste tu contraseña ?</a>
          </q-card-actions>
        </q-card>
        <br><br>
      </div>

      <q-dialog class="bg-white" v-model="showTerms">
        <q-card>
          <q-card-section>
            <div class="text-h6">Términos y condiciones</div>
          </q-card-section>

          <q-card-section class="bg-white">
          
          </q-card-section>

          <q-card-actions align="center">
              <q-toggle v-model="form.accept" label="Acepto los términos y condiciones"
                        @input="showTerms = false"/>
          </q-card-actions>
        </q-card>
      </q-dialog>
      <q-dialog class="bg-white" v-model="alert">
        <div>
          <q-card-section>
            <div class="text-h6">Bienvenido a NexArg!</div>
          </q-card-section>

          <q-card-section class="bg-white">
            Te has registrado exitosamente !
            Podes acceder con tu usuario y contraseña
          </q-card-section>

          <q-card-actions align="center">
            <q-btn flat :to="{ name: 'login' }" label="Acceder"
                   color="primary" v-close-popup/>
          </q-card-actions>
        </div>
      </q-dialog>
    </div>
  </q-page>
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
      QCardSection,
      QToggle,
      QIcon,
      QCardActions,
      QParallax,
      QDialog,
    },
    mixins: [],
    data() {
      return {
        isPwd: true,
        showTerms: false,
        form: {
          name: null,
          last_name: null,
          password: null,
          password_confirmation: null,
          dni: null,
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
        name: { required },
        last_name: { required },
        email: { required },
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
    methods: {
      async onSubmit() {
        try {
          this.loading = true
          this.$v.form.$touch()
          if (!this.$v.form.$error) {
            const resp = await userApi.register(this.form)
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
    }
  }
</script>

<style scoped>

  .q-page {
    /*margin-top: 170px;*/
  }
</style>
