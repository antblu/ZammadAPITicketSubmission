<template>
  <div class="p-6">
    <h1 class="app-title">{{ t('zammadapiticketsubmission', 'Submit a Zammad Ticket') }}</h1>

    <form @submit.prevent="submitTicket" class="ticket-form">
      <div class="field">
        <label for="subject">{{ t('zammadapiticketsubmission', 'Subject') }}</label>
        <input id="subject" v-model="form.subject" required />
      </div>

      <div class="field">
        <label for="email">{{ t('zammadapiticketsubmission', 'Requester Email') }}</label>
        <input id="email" type="email" v-model="form.customer" required />
      </div>

      <div class="field">
        <label for="priority">{{ t('zammadapiticketsubmission', 'Priority') }}</label>
        <select id="priority" v-model="form.priority">
          <option value="1">{{ t('zammadapiticketsubmission', '1 low') }}</option>
          <option value="2">{{ t('zammadapiticketsubmission', '2 normal') }}</option>
          <option value="3">{{ t('zammadapiticketsubmission', '3 high') }}</option>
        </select>
      </div>

      <div class="field">
        <label for="body">{{ t('zammadapiticketsubmission', 'Message') }}</label>
        <textarea id="body" v-model="form.body" rows="6" required />
      </div>

      <div class="actions">
        <button type="submit" :disabled="submitting">
          {{ submitting ? t('zammadapiticketsubmission', 'Submitting…') : t('zammadapiticketsubmission', 'Create Ticket') }}
        </button>
        <span v-if="successMsg" class="success">{{ successMsg }}</span>
        <span v-if="errorMsg" class="error">{{ errorMsg }}</span>
      </div>
    </form>

    <hr class="divider" />

    <DashboardWidget />
  </div>
</template>

<script>
import DashboardWidget from './widget/DashboardWidget.vue'

export default {
  name: 'ZammadApiTicketSubmissionApp',
  components: { DashboardWidget },
  data () {
    return {
      submitting: false,
      successMsg: '',
      errorMsg: '',
      form: {
        subject: '',
        body: '',
        customer: '',
        priority: '2',
        tags: []
      }
    }
  },
  methods: {
    async submitTicket () {
      this.submitting = true
      this.successMsg = ''
      this.errorMsg = ''

      try {
        const resp = await fetch(OC.generateUrl('/ocs/v2.php/apps/zammadapiticketsubmission/api/tickets'), {
          method: 'POST',
          headers: {
            'OCS-APIRequest': 'true',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.form),
          credentials: 'same-origin'
        })

        if (!resp.ok) {
          const txt = await resp.text()
          throw new Error(`HTTP ${resp.status}: ${txt}`)
        }

        const data = await resp.json()
        // Expecting { ocs: { data: { id, number, ... } } }
        const ticket = data?.ocs?.data
        this.successMsg = this.t('zammadapiticketsubmission', 'Ticket created successfully') + (ticket?.number ? ` (#${ticket.number})` : '')
        this.form.subject = ''
        this.form.body = ''
        this.form.customer = ''
        this.form.priority = '2'
        this.form.tags = []
      } catch (e) {
        console.error(e)
        this.errorMsg = this.t('zammadapiticketsubmission', 'Failed to create ticket') + ': ' + (e?.message || e)
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>

<style scoped>
.app-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
.ticket-form .field {
  display: flex;
  flex-direction: column;
  margin-bottom: 0.75rem;
}
.ticket-form input,
.ticket-form textarea,
.ticket-form select {
  padding: 0.5rem 0.75rem;
  border: 1px solid var(--color-border);
  border-radius: 6px;
  background: var(--color-main-background);
  color: var(--color-main-text);
}
.actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.actions button {
  padding: 0.5rem 0.9rem;
  border: none;
  border-radius: 6px;
  background: var(--color-primary);
  color: white;
  cursor: pointer;
}
.success { color: var(--color-success); }
.error { color: var(--color-error); }
.divider {
  margin: 2rem 0 1rem;
  border: none;
  border-top: 1px solid var(--color-border);
}
</style>
