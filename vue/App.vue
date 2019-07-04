<template>
  <div class="container container-event">
    <div class="columns">
      <div class="column is-one-third">
        <event-form @close="toggleForm" />
      </div>
      <div class="column">
        <calendar />
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
  data () {
    return {
      isFormOpen: false
    }
  },
  mounted () {
    this.getEventDates()
  },
  methods: {
    ...mapActions({
      getEventDates: 'getEventDates'
    }),
    toggleForm (close = true) {
      this.isFormOpen = close
    }
  }
}
</script>

<style lang="scss" scoped>
  .container-event {
    margin-top: 20px;
  }
</style>
