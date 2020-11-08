<template>
  <div class="q-pa-md">
    <q-table
      title="Presupuestos"
      :data="mainTable.data"
      :no-data-label="'No se encontraron presupuestos'"
      :columns="columns"
      :loading="mainTable.loading"
      row-key="name"
      selection="multiple"
      :selected.sync="selected"
    >
      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td auto-width>
            <q-checkbox class="q-ml-sm" dense v-model="props.selected"/>
          </q-td>
          <q-td key="client_name" :props="props">{{ props.row.client_name }}</q-td>
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
        <div class="col-2 q-table__title">Presupuestos</div>

        <q-space/>
        <q-btn label="Crear presupuesto" color="primary"
               @click="openModalCreate()"/>
      </template>
    </q-table>
    <q-form @submit="submit()">
      <q-dialog v-model="showModalCreate">
        <q-card :class="{'big-modal': !$q.platform.is.mobile }">
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
            <q-select
              use-input
              label="Seleccionar cliente"
              :options="clients.data"
              :error="$v.form.client.$error"
              filled
              input-debounce="600"
              v-model="form.client"
              @filter="filterFn"
              @filter-abort="abortFilterFn"
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Sin resultados
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
            <div class="row">
              <div class="col-md-4 bg-grey-3">
                <q-form @submit="submitItem">
                  <div class="row">
                    <div class="col-12 q-pa-sm">
                      <q-select
                        :options="products.data"
                        :error="$v.newItemForm.product.$error"
                        :loading="products.loading"
                        v-model="newItemForm.product"
                        label="Seleccionar producto">
                      </q-select>
                    </div>
                    <div class="col-12 q-pr-sm q-pl-sm">
                      <q-input
                        min="1"
                        label="Cantidad"
                        :error="$v.newItemForm.quantity.$error"
                        v-model.number="newItemForm.quantity"></q-input>
                    </div>
<!--                    <div class="col-12 q-pr-sm q-pl-sm">-->
<!--                      <q-input-->
<!--                        min="1"-->
<!--                        label="Precio"-->
<!--                        :error="$v.newItemForm.quantity.$error"-->
<!--                        v-model.number="newItemForm.quantity"></q-input>-->
<!--                    </div>-->
                    <div class="col-12 q-pa-sm">
                      <q-btn label="Agregar" size="sm"
                             class="full-width pull-right"
                             color="blue-8" type="submit" icon="save"/>
                    </div>
                  </div>
                </q-form>
              </div>
              <div class="col-md-8 q-pl-md">
                <div class="q-pt-sm q-pb-sm">
                  <q-markup-table dark class="bg-indigo-5">
                    <thead>
                    <tr>
                      <th class="text-left">Item</th>
                      <th class="text-left">Cantidad</th>
                      <th class="text-right">Precio (U$D)</th>
                      <th class="text-right">IVA</th>
                      <th class="text-right">Monto</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,value) in form.items" :key="value">
                      <td class="text-left">
                        {{ item.product.label }}
                      </td>
                      <td class="text-right" style="max-width: 50px;position: relative;">
                        <q-input type="number" v-model="item.quantity"
                            label="Cantidad" style="max-width: 50px !important;"/>
                      </td>
                      <td class="text-right">
                        <span v-text="item.product.price"></span>
                      </td>
                      <td class="text-right">10.5 %</td>
                      <td>
                        <span v-text="item.product.total"></span>
                      </td>
                    </tr>
                    </tbody>
                  </q-markup-table>
                </div>

                <q-input type="textarea" v-model="form.details"
                         label="Observaciones presupuesto" rows="2"></q-input>
              </div>

            </div>

          </q-card-section>

          <q-card-section class="text-right">
            <q-space/>
            <q-btn flat type="button" color="grey"
                   @click="closeModal"
                   align="right" label="Cancelar"/>
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
    QMarkupTable,
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
      QMarkupTable,
    },
    mixins: [validate],
    data() {
      return {
        products: {
          data: [],
          loading: false,
        },
        budgets: {
          data: [],
          loading: false,
        },
        clients: {
          data: [],
        },
        mainTable: {
          data: [],
          loading: false,
        },
        columns: [
          {
            name: 'client_name',
            field: 'client_name',
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
          client: null,
          items: []
        },
        formDelete: {
          id: null,
          client: null
        },
        newItemForm: {
          product: null,
          quantity: 1,
          price: null
        }
      }
    },
    validations: {
      form: {
        client: {required},
      },
      newItemForm: {
        product: {required},
        quantity: {required}
      }
    },
    mounted() {
      this.initView()
    },
    methods: {
      submitItem() {
        this.form.items.push(this.newItemForm)
        this.resetNewItemForm()
      },
      closeModal() {
        this.showModalCreate = false
        this.showModalUpdate = false
      },
      resetNewItemForm() {
        this.newItemForm.product = null
        this.newItemForm.quantity = 1
        this.newItemForm.price = null

      },
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
        this.getBudgets()
        this.getProducts()
      },
      openDeleteModal(row) {
        this.formDelete.id = row.id
        this.formDelete.client = row.client
        this.showModalDelete = true
      },

      async submit() {
        if (!this.validateForm()) {
          return
        }
        try {
          const resp = await this.$axios({
            url: 'api/v1/budgets/resource',
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
        this.resetNewItemForm()
        this.showModalCreate = true
        this.form.id = null
        this.form.client = null
        this.form.details = null
        for (let i = 0; i < this.products.data.length; i++) {
          debugger
          if (this.products.data[i].auto_budget) {
            this.form.items.push({
              quantity: 1,
              product: this.products.data[i],
              price: this.products.data[i].price,
              iva: 10.5
            })
          }
        }
      },
      openUpdateModal(row) {
        this.resetNewItemForm()
        this.showModalCreate = true
        this.form.id = row.id
        this.form.client = row.client
        this.form.details = row.details
      },
      async deleteModel() {
        try {
          const resp = await this.$axios({
            url: `api/v1/budgets/resource/${this.formDelete.id}`,
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
      async getProducts() {
        try {
          this.products.loading = true
          const resp = await this.$axios({
            url: 'api/v1/products/forSelect',
            method: 'POST'
          })
          this.products.data = resp.data
        } catch (e) {
          this.products = []
        } finally {
          this.products.loading = false
        }
      },
      async getBudgets() {
        try {
          this.mainTable.loading = true
          const resp = await this.$axios({
            url: 'api/v1/budgets/resource',
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
        this.getBudgets()
      }
    }
    // name: 'PageName',
  }
</script>

<style scoped>
  .big-modal {
    min-width: 1000px;
    max-width: 90vw;
  }
</style>
