import axios from 'axios'

export const createEvent = async ({ commit }, event) => {
  return axios.post('/api/events', event)
}

export const syncEvent = async ({ commit }, event) => {
  return axios.put(`/api/events/${event.id}`, event)
}

export const getEventDates = ({ commit }, filters) => {
  return axios.get('/api/event-dates', { 
    params: {
      include: 'event',
    }
  }).then(({ data }) => {
    commit('setEventDates', data.data)
  })
}
