export default {
  methods: {
    validateForm(array = 'form') {
      this.$v[array].$touch()
      if (this.$v[array].$error) {
        this.$q.notify({
          message: 'Revise los datos faltantes en el formulario.',
          type: 'negative',
          timeout: 3000,
          position: 'top',
        })
        return false
      }
      return true
    }
  }
}
