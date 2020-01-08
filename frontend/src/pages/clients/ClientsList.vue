<template>
  <div class="q-pa-md">
    <q-table
      title="Clientes"
      :data="mainTable.data"
      :columns="columns"
      :loading="loadingTable"
      row-key="name"
      selection="multiple"
      :selected.sync="selected"
    >
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td auto-width>
            <q-checkbox class="q-ml-sm" dense v-model="props.selected"/>
          </q-td>
          <q-td key="legal_name" :props="props">{{ props.row.legal_name }}</q-td>
          <q-td key="state" :props="props">
            <q-badge color="secondary">{{ props.row.state }}</q-badge>
          </q-td>
          <q-td key="actions" :props="props">
            <q-btn size="xs" @click="openDeleteModal(props.row)"
                   class="q-mr-md" color="negative" icon="delete"/>
            <q-btn size="xs" @click="openUpdateModal(props.row)"
                   class="q-mr-md" color="info" icon="edit"/>
          </q-td>
        </q-tr>
      </template>
      <template v-slot:top="props">
        <div class="col-2 q-table__title">Clientes</div>

        <q-space/>
        <q-btn label="Crear cliente" color="primary"
               @click="openModalCreate()"/>
      </template>
    </q-table>
    <q-form @submit="submit()">
      <q-dialog v-model="showModalCreate">
        <q-card>
          <q-bar>
            <span v-if="!form.id">
                  Crear presupuesto
            </span>
            <span v-if="form.id">
                  Actualizar presupuesto
            </span>
            <q-space/>

            <q-btn dense flat icon="close" v-close-popup>
              <q-tooltip>Cerrar</q-tooltip>
            </q-btn>
          </q-bar>

          <q-card-section>
            <!--            <q-select-->
            <!--              use-input-->
            <!--              label="Seleccionar cliente"-->
            <!--              :options="clients.data"-->
            <!--              :error="$v.form.client.$error"-->
            <!--              filled-->
            <!--              input-debounce="600"-->
            <!--              v-model="form.client"-->
            <!--              @filter="filterFn"-->
            <!--              @filter-abort="abortFilterFn"-->
            <!--            >-->
            <!--              <template v-slot:no-option>-->
            <!--                <q-item>-->
            <!--                  <q-item-section class="text-grey">-->
            <!--                    Sin resultados-->
            <!--                  </q-item-section>-->
            <!--                </q-item>-->
            <!--              </template>-->
            <!--            </q-select>-->
            <q-input v-model="form.legal_name"
                     label="Razón Social"></q-input>
            <q-input v-model="form.cuit"
                     label="CUIT"></q-input>
            <q-input v-model="form.address"
                     label="Dirección"></q-input>
            <q-input type="textarea" v-model="form.details"
                     label="Observaciones cliente" rows="3"></q-input>

          </q-card-section>

          <q-card-section class="text-right">
            <q-space/>
            <q-btn flat type="submit" color="warning"
                   align="right" label="Cerrar" v-close-popup/>
            <q-btn @click="submit" type="submit" color="primary"
                   align="right" :label="form.id ? 'Actualizar' : 'Crear'"/>
          </q-card-section>
        </q-card>
      </q-dialog>
    </q-form>
    <q-form @submit="deleteModel()">
      <q-dialog v-model="showModalDelete">
        <q-card>
          <q-bar>
            Eliminar
            <q-space/>

            <q-btn dense flat icon="close" v-close-popup>
              <q-tooltip>Cerrar</q-tooltip>
            </q-btn>
          </q-bar>

          <q-card-section v-if="formDelete.name">
            Desea eliminar la categoría {{ formDelete.name }}
          </q-card-section>

          <q-card-section class="text-right">
            <q-space/>
            <q-btn @click="deleteModel" type="submit" color="primary"
                   align="right" label="Eliminar"/>
          </q-card-section>
        </q-card>
      </q-dialog>
    </q-form>
  </div>
</template>

<script>
  import {
    QTable,
    QBadge,
    QSpace,
    QDialog,
    QCard,
    QTooltip,
    QForm,
    QRadio,
    QBtn,
    QTr,
    QTd,
    QCheckbox,
    QInput,
    QCardSection,
    QField,
    QBar,
  } from 'quasar'

  const {required} = require('vuelidate/lib/validators')
  import validate from '../mixins/validate'

  export default {
    components: {
      QTable,
      QField,
      QRadio,
      QBadge,
      QInput,
      QSpace,
      QBtn,
      QTr,
      QCheckbox,
      QTd,
      QDialog,
      QCard,
      QForm,
      QTooltip,
      QCardSection,
      QBar,
    },
    mixins: [validate],
    data() {
      return {
        mainTable: {
          data: [],
          loading: false,
        },
        loadingTable: false,
        clients: {
          data: [],
        },
        columns: [
          {
            name: 'legal_name',
            field: 'legal_name',
            label: 'Cliente',
            align: 'left',
            sortable: true,
            required: true
          },
          {
            name: 'category_state',
            field: 'category_state',
            label: 'Categoría',
            align: 'left',
            sortable: true,
            required: true
          },
          {
            name: 'actions',
            field: 'actions',
            label: 'Acciones',
            align: 'left',
            sortable: false,
            required: false
          },
        ],
        showModalCreate: false,
        showModalDelete: false,
        showModalUpdate: false,
        selected: [],
        form: {
          id: null,
          legal_name: null,
          cuit: null,
          address: null
        },
        formDelete: {
          id: null,
          legal_name: null,
          cuit: null,
          address: null
        }
      }
    },
    validations: {
      form: {
        legal_name: {required},
        cuit: {required},
        address: {required},
      }
    },
    mounted() {
      this.initView()
    },
    methods: {
      async filterFn(val, update, abort) {
        // if (this.clients.data !== null) {
        //   // already loaded
        //   update()
        //   return
        // }
        if (!val) {
          return
        }
        const resp = await this.$axios.post('api/v1/clients/forSelect', {
          filter: val
        })
        update(() => {
          this.clients.data = resp.data
        })
        return
      },

      abortFilterFn() {
        // console.log('delayed filter aborted')
      },
      initView() {
        this.getClients()
      },
      openDeleteModal(row) {
        this.formDelete.id = row.id
        this.formDelete.legal_name = row.legal_name
        this.formDelete.cuit = row.cuit
        this.formDelete.address = row.address
        this.showModalDelete = true
      },

      async submit() {
        if (!this.validateForm()) {
          return
        }
        try {
          const resp = await this.$axios({
            url: 'api/v1/clients/resource',
            data: this.form,
            method: 'POST'
          })
          this.$q.notify({
            type: resp.data.error ? 'negative' : 'positive',
            message: resp.data.msg
          })
          this.getBudgets()
        } catch (e) {
          this.$q.notify({
            type: 'negative',
            message: 'Error de servidor'
          })
        } finally {
          this.showModalCreate = false
        }
      },
      openModalCreate() {
        this.showModalCreate = true
        this.form.id = null
        this.form.client = null
        this.form.details = null
      },
      openUpdateModal(row) {
        this.showModalCreate = true
        this.form.id = row.id
        this.form.client = row.client
        this.form.details = row.details
      },
      async deleteModel() {
        try {
          const resp = await this.$axios({
            url: `api/v1/clients/resource/${this.formDelete.id}`,
            data: this.formDelete,
            method: 'delete',
          })
          this.$q.notify({
            type: resp.data.error ? 'negative' : 'positive',
            message: resp.data.msg
          })
          this.getBudgets()
        } catch (e) {
          this.$q.notify({
            type: 'negative',
            message: 'Error de servidor'
          })
        } finally {
          this.showModalDelete = false
        }
      },
      async updateModel() {

      },
      async getClients() {
        try {
          this.mainTable.loading = true
          const resp = await this.$axios({
            url: 'api/v1/clients/resource',
            params: {
              type: 'product'
            },
            method: 'GET'
          })
          this.mainTable.data = resp.data.data
        } catch (e) {
          this.products = []
        } finally {
          this.mainTable.loading = false
        }
      }
    },
    events: {
      'reload-table'() {
        this.getClients()
      }
    }
    // name: 'PageName',
  }
</script>
