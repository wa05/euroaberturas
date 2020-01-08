export function PROVINCES_FOR_SELECT (state, data) {
  state.provinces.data = data.data
  state.provinces.loading = false
}
export function DEPARTMENTS_FOR_SELECT (state, data) {
  state.departments.data = data.data
  state.departments.loading = false
}
export function CITIES_FOR_SELECT (state, data) {
  state.cities.data = data.data
  state.cities.loading = false
}
