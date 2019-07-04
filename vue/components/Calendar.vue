<template>
  <full-calendar
    ref="calendar"
    @click="onDateClick"
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
  mounted () {
    const calendarApi = this.$refs.calendar.getApi()
    console.log(calendarApi)
  },
  computed: {
    ...mapGetters({
      events: 'events'
    })
  },
  methods: {
    onDateClick (day) {
      console.log(day)
    }
  }
}
</script>

<style lang="scss">
  @import '~@fullcalendar/core/main.css';
  @import '~@fullcalendar/daygrid/main.css';
</style>