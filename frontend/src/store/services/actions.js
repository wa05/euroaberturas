import services from '../../services/api/Service'

export async function getMyServices(context, params) {
  const resp = await services.myServices(params)
  context.commit('MY_SERVICES', resp)
}

export async function getHomeServices(context, params) {
  const resp = await services.getHomeServices(params)
  context.commit('HOME_SERVICES', resp.data)
}

export async function getPublicationDetail(context, params) {
  const resp = await services.getPublicationDetail(params)
  context.commit('GET_PUBLICATION_DETAIL', resp.data)
}

export async function toggleDelete(context, id) {
  context.commit('TOGGLE_DELETE_MODAL', id)
}

export async function deleteService({dispatch}, id) {
  const resp = await services.deleteService(id)
  dispatch('getMyServices')
}

export async function requestService(context, params) {
  const resp = await services.requestService(params)
  context.commit('RELOAD_SERVICE_DATA')
}

