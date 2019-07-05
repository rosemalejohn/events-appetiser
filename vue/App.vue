<template>
<div class="section">
  <div class="container">
    <div class="columns">
      <div class="column is-one-third">
        <event-form />
      </div>
      <div class="column">
        <calendar />
      </div>
    </div>
  </div>
</div>
</template>

<script>
import EventForm from './components/EventForm'
import Calendar from './components/Calendar'
import { mapActions } from 'vuex'

export default {
  components: {
    EventForm,
    Calendar
  },
  mounted () {
    this.getEventDates()
  },
  methods: {
    ...mapActions({
      getEventDates: 'getEventDates'
    })
  }
}
</script>
