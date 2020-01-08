import serviceCategory from '../../services/api/ServiceCategory'

export async function catsForSelect (context, params) {
  const resp = await serviceCategory.catsForSelect(params)
  context.commit('CATEGORIES_FOR_SELECT', resp)
}

export async function subcatsForSelect (context, params) {
  const resp = await serviceCategory.subcatsForSelect(params)
  context.commit('SUBCATEGORIES_FOR_SELECT', resp)
}
