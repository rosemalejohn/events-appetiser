<template>
  <full-calendar
    ref="calendar"
    :events="events"
    :plugins="calendarPlugins"
  />
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import { mapGetters } from 'vuex'

export default {
  components: {
    FullCalendar
  },
  data () {
    return {
      calendarPlugins: [
        dayGridPlugin
      ]
    }
  },
  computed: {
    ...mapGetters({
      events: 'events'
    })
  }
}
</script>

<style lang="scss">
  @import '~@fullcalendar/core/main.css';
  @import '~@fullcalendar/daygrid/main.css';
</style>