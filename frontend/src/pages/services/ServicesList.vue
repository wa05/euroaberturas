<template>
  <div class="q-pa-md">
    <q-table
      title="Servicios"
      :data="products.data"
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
          <q-td key="name" :props="props">{{ props.row.name }}</q-td>
          <q-td key="price" :props="props">{{ props.row.price }}</q-td>
          <q-td key="category_title" :props="props">
            <q-badge color="secondary">{{ props.row.category_title }}</q-badge>
          </q-td>
          <q-td key="actions" :props="props">
            <q-btn size="xs" @click="openUpdateModal(props.row)"
                   class="q-mr-md" color="info" icon="edit"/>
            <q-btn size="xs" @click="openDeleteModal(props.row)"
                   class="q-mr-md" color="negative" icon="delete"/>
          </q-td>
        </q-tr>
      </template>
      <template v-slot:top="props">
        <div class="col-2 q-table__title">Servicios</div>

        <q-space/>
        <q-btn label="Crear servicio" color="primary"
               @click="openModalCreate()"/>
      </template>
    </q-table>
    <q-form @submit="submit()">
      <q-dialog v-model="showModalCreate">
        <q-card>
          <q-bar>
            <span v-if="!form.id">
                  Crear servicio
            </span>
            <span v-if="form.id">
                  Actualizar servicio
            </span>
            <q-space/>

            <q-btn dense flat icon="close" v-close-popup>
              <q-tooltip>Cerrar</q-tooltip>
            </q-btn>
          </q-bar>

          <q-card-section>
            <div class="q-gutter-sm">
              Categoría
              <q-field :error="$v.form.category.$error">
                <q-radio v-model="form.category" val="ABERTURA" label="Abertura"
                         :error="$v.form.category.$error"/>
                <q-radio v-model="form.category" val="PERSIANA" label="Persiana"
                         :error="$v.form.category.$error"/>
              </q-field>
            </div>
            <div class="q-gutter-sm">
              Agregar a presupuesto por defecto
              <q-field :error="$v.form.auto_budget.$error">
                <q-radio v-model="form.auto_budget" val="yes" label="SI"
                         :error="$v.form.auto_budget.$error"/>
                <q-radio v-model="form.auto_budget" val="no" label="NO"
                />
              </q-field>
            </div>
            <q-input label="Nombre del servicio" v-model="form.name"
                     :error="$v.form.name.$error"/>
            <q-input v-model="form.price" label="Precio (u$d)" class="q-mt-sm"
                      :error="$v.form.price.$error"></q-input>
          </q-card-section>

          <q-card-section class="text-right">
            <q-space/>
            <q-btn @click="showModalCreate = false" flat type="submit" color="primary"
                   align="right" label="Cancelar"/>
            <q-btn :disable="loadingSave"
                   @click="submit" type="submit" color="primary"
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
            <q-btn :disable="loadingSave" @click="deleteModel" type="submit" color="primary"
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
    QField,
    QForm,
    QRadio,
    QBtn,
    QTr,
    QTd,
    QCheckbox,
    QInput,
    QCardSection,
    QBar,
  } from 'quasar'

  const {required} = require('vuelidate/lib/validators')
  import validate from '../mixins/validate'

  export default {
    components: {
      QTable,
      QRadio,
      QField,
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
        products: [],
        loadingTable: false,
        columns: [
          {
            name: 'name',
            field: 'name',
            label: 'Nombre',
            align: 'left',
            sortable: true,
            required: true
          },
          {
            name: 'price',
            field: 'price',
            label: 'Precio',
            align: 'left',
            sortable: true,
            required: true
          },
          {
            name: 'category_title',
            field: 'category_title',
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
          name: null,
          price: null,
          category: 'ABERTURA',
          type: 'service',
          auto_budget: 'no'
        },
        formDelete: {
          name: '',
          id: null
        },
        loadingSave: false
      }
    },
    validations: {
      form: {
        name: {required},
        category: {required},
        type: {required},
        price: {required},
        auto_budget: {required},
      }
    },
    mounted() {
      this.initView()
    },
    methods: {
      initView() {
        this.getProducts()
      },
      openDeleteModal(row) {
        this.formDelete.name = row.name
        this.formDelete.id = row.id
        this.showModalDelete = true
      },

      async submit() {
        if (!this.validateForm()) {
          return
        }
        try {
          this.loadingSave = true
          const resp = await this.$axios({
            url: 'api/v1/products/resource',
            data: this.form,
            method: 'POST'
          })
          this.$q.notify({
            type: resp.data.error ? 'negative' : 'positive',
            message: resp.data.msg
          })
          this.getProducts()
        } catch (e) {
          this.$q.notify({
            type: 'negative',
            message: 'Error de servidor'
          })
        } finally {
          this.loadingSave = false
          this.showModalCreate = false
        }
      },
      openModalCreate() {
        this.showModalCreate = true
        this.form.auto_budget = 'no'
        this.form.id = null
        this.form.category = null
        this.form.name = null
      },
      openUpdateModal(row) {
        this.showModalCreate = true
        this.form.id = row.id
        this.form.price = row.price
        this.form.auto_budget = row.auto_budget ? 'yes' : 'no'
        this.form.category = row.category_title
        this.form.name = row.name
      },
      async deleteModel() {
        try {
          this.loadingSave = true
          const resp = await this.$axios({
            url: `api/v1/products/resource/${this.formDelete.id}`,
            data: this.formDelete,
            method: 'delete',
          })
          this.$q.notify({
            type: resp.data.error ? 'negative' : 'positive',
            message: resp.data.msg
          })
          this.getProducts()
        } catch (e) {
          this.$q.notify({
            type: 'negative',
            message: 'Error de servidor'
          })
        } finally {
          this.loadingSave = false
          this.showModalDelete = false
        }
      },
      async getProducts() {
        try {
          this.loadingTable = true
          const resp = await this.$axios({
            url: 'api/v1/products/resource',
            params: {
              type: 'service'
            },
            method: 'GET'
          })
          this.products = resp.data
        } catch (e) {
          this.products = []
          this.loadingTable = false
        } finally {
          this.loadingTable = false
        }
      }
    },
    events: {
      'reload-table'() {
        this.getProducts()
      }
    }
    // name: 'PageName',
  }
</script>
