<template>
  <div>
    <b-button
      @click="resetForm"
      class="add-event"
      type="is-info"
      outlined
      rounded
      icon-left="plus"
    >
      Add new event
    </b-button>

    <b-button
      @click="clearEvents"
      class="add-event"
      type="is-info"
      outlined
      rounded
      icon-left="delete"
    >
      Clear events
    </b-button>

    <form @submit.prevent="submit" ref="form">
      <b-field
        label="Event title"
        :type="{'is-danger': errors.has('title')}"
        :message="errors.first('title')"
      >
        <b-input
          type="text"
          name="title"
          v-model="form.title"
          v-validate="'required'"
          placeholder="Add your event a title"
        >
        </b-input>
      </b-field>

      <div class="columns">
        <div class="column">
          <b-field
            label="Date from"
            :type="{'is-danger': errors.has('from')}"
            :message="errors.first('from')"
          >
            <b-datepicker
              v-validate="'required'"
              name="from"
              v-model="form.date_from"
              :max-date="form.date_to"
              placeholder="Pick start date"
            >
            </b-datepicker>
          </b-field>
        </div>

        <div class="column">
          <b-field
            label="Date to"
            :type="{'is-danger': errors.has('to')}"
            :message="errors.first('to')"
          >
            <b-datepicker
              v-validate="'required'"
              name="to"
              v-model="form.date_to"
              :min-date="form.date_from"
              placeholder="Pick end date"
            >
            </b-datepicker>
          </b-field>
        </div>
      </div>

      <b-field
        v-show="form.date_from && form.date_to"
        label="Week days"
        :type="{'is-danger': errors.has('days')}"
        :message="errors.first('days')"
      >
        <div class="block">
          <b-checkbox
            name="days"
            v-validate="'required'"
            v-model="form.days"
            v-for="(day, index) in week"
            :native-value="index"
            :key="day"
          >
            {{ day }}
          </b-checkbox>
        </div>
      </b-field>

      <b-button
        :loading="isSubmitting"
        native-type="submit"
        rounded
        class="button is-info"
      >
        {{ this.form.id ? 'Update' : 'Create' }}
      </b-button>
    </form>
  </div>
</template>

<script>
  import moment from 'moment'
  import { mapActions } from 'vuex'
  import _each from 'lodash/each'
  import _uniq from 'lodash/uniq'
  import _concat from 'lodash/concat'

  export default {
    data () {
      return {
        isSubmitting: false,
        week: moment.weekdaysShort(),
        form: {
          id: null,
          title: '',
          date_from: null,
          date_to: null,
          days: []
        }
      }
    },
    methods: {
      ...mapActions({
        createEvent: 'createEvent',
        syncEvent: 'syncEvent',
        getEventDates: 'getEventDates',
        deleteAllEvents: 'deleteAllEvents'
      }),
      resetForm () {
        this.$validator.reset()
        this.form = {
          id: null,
          title: '',
          date_from: null,
          date_to: null,
          days: []
        }
      },
      getDayDates (start, end, day) {
        let dates = []
        let temp = start.clone().day(day)

        while(temp.isSameOrBefore(end)) {
          if (temp.isSameOrAfter(start, 'd')) {
            dates.push(temp.format('YYYY-MM-DD'))
          }
          temp.add(7, 'days')
        }

        return dates
      },
      submit () {
        this.$validator.validateAll().then((valid) => {
          if (valid) {
            this.isSubmitting = true
            let dates = []
            const start = moment(this.form.date_from, 'YYYY-MM-DD')
            const end = moment(this.form.date_to, 'YYYY-MM-DD')

            _each(this.form.days, (day) => {
              dates = _concat(dates, this.getDayDates(start, end, day))
            })

            const formData = {
              ...this.form,
              date_from: start.format('YYYY-MM-DD'),
              date_to: end.format('YYYY-MM-DD'),
              dates: _uniq(dates)
            }

            if (!dates.length) {
              this.isSubmitting = false
              this.$snackbar.open({
                duration: 4000,
                message: 'No dates are within the days selected.',
                type: 'is-danger',
                position: 'is-top'
              })
              return
            }

            if (this.form.id) {
              this.updateEvent(formData)
            } else {
              this.addEvent(formData)
            }

          }
        })
      },
      addEvent (event) {
        this.createEvent(event)
          .then(({data}) => {
            this.form.id = data.data.id
            this.$emit('close')
            this.$snackbar.open({
              duration: 4000,
              message: 'Event succesfully added.',
              type: 'is-success',
              position: 'is-top'
            })
          })
          .then(this.getEventDates)
          .catch(() => {
            this.$snackbar.open({
              duration: 4000,
              message: 'Something went wrong.',
              type: 'is-danger',
              position: 'is-top'
            })
          })
          .then(() => {
            this.isSubmitting = false
          })
      },
      updateEvent (event) {
        this.syncEvent(event)
          .then(this.getEventDates)
          .then(() => {
            this.$snackbar.open({
              duration: 4000,
              message: 'Event succesfully updated.',
              type: 'is-success',
              position: 'is-top'
            })
          }).catch(() => {
            this.$snackbar.open({
              duration: 4000,
              message: 'Something went wrong.',
              type: 'is-danger',
              position: 'is-top'
            })
          }).then(() => {
            this.isSubmitting = false
          })
      },
      clearEvents () {
        this.resetForm()
        this.deleteAllEvents()
          .then(this.getEventDates)
      }
    }
  }
</script>

<style scoped>
  .add-event {
    margin-bottom: 20px;
  }
</style>