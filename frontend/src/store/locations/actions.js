import LocationApi from '../../services/api/Location'

export async function getProvinces(context, params) {
  const resp = await LocationApi.getProvinces(params)
  context.commit('PROVINCES_FOR_SELECT', resp)
}

export async function getDepartments(context, params) {
  const resp = await LocationApi.getDepartments(params)
  context.commit('DEPARTMENTS_FOR_SELECT', resp)
}

export async function getCities(context, params) {
  const resp = await LocationApi.getCities(params)
  context.commit('CITIES_FOR_SELECT', resp)
}
