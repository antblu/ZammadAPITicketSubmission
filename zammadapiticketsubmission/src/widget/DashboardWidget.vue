<template>
  <div class="widget">
    <h2>{{ t('zammadapiticketsubmission', 'Quick Ticket Widget') }}</h2>
    <p>{{ t('zammadapiticketsubmission', 'Use the form above to submit a ticket to Zammad.') }}</p>
    <ul class="hints">
      <li>{{ t('zammadapiticketsubmission', 'Tickets are sent via the server using your configured API token.') }}</li>
      <li>{{ t('zammadapiticketsubmission', 'You will see the Zammad ticket number after creation.') }}</li>
    </ul>
  </div>
</template>

<script>
export default { name: 'DashboardWidget' }
</script>

<style scoped>
.widget {
  padding: 1rem;
  border-radius: 8px;
  background: var(--color-background-dark);
  border: 1px solid var(--color-border-dark);
}
.hints { margin: 0.5rem 1rem; }
</style>
