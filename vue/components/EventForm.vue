<template>
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
      v-if="form.date_from && form.date_to"
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
    <!-- <button class="button" type="button" @click="$parent.close()">Close</button> -->
    <button type="submit" class="button is-primary">Submit</button>
  </form>
</template>

<script>
  import moment from 'moment'
  import { mapActions } from 'vuex'

  export default {
    data () {
      return {
        week: moment.weekdaysShort(),
        form: {
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
        getEventDates: 'getEventDates'
      }),
      resetForm () {
        this.form = {
          title: '',
          date_from: null,
          date_to: null,
          days: []
        }
      },
      getDayDates (start, end, day) {
        let dates = []
        let temp = start.clone().day(day)

        if (temp.isAfter(start, 'd')) {
          dates.push(temp.format('YYYY-MM-DD'))
        }

        while(temp.isBefore(end)) {
          dates.push(temp.format('YYYY-MM-DD'))
          temp.add(7, 'days')
        }

        return dates
      },
      submit () {
        this.$validator.validateAll().then((valid) => {
          if (valid) {
            let dates = []
            const start = moment(this.form.date_from, 'YYYY-MM-DD')
            const end = moment(this.form.date_to, 'YYYY-MM-DD')

            this.form.days.forEach((day) => {
              dates = dates.concat(this.getDayDates(start, end, day))
            })

            this.addEvent({
              ...this.form,
              date_from: start.format('YYYY-MM-DD'),
              date_to: end.format('YYYY-MM-DD'),
              dates
            })
          }
        })
      },
      addEvent (event) {
        this.createEvent(event)
          .then(this.getEventDates)
          .then(() => {
            this.resetForm()
            this.$emit('close')
            this.$snackbar.open({
              duration: 4000,
              message: 'Event succesfully added.',
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
          })
      }
    }
  }
</script>