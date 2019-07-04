export const events = (state) => {
  return state.eventDates.map((eventDate) => {
    return {
      title: eventDate.event.title,
      start: eventDate.date,
      allDay: true
    }
  })
}
