export function CATEGORIES_FOR_SELECT (state, data) {
  state.forSelectCats.data = data
    state.forSelectCats.loading = false
}
export function SUBCATEGORIES_FOR_SELECT (state, data) {
  state.forSelectSubcats.data = data
  state.forSelectSubcats.loading = false
}
