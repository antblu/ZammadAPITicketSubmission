# Zammad API Ticket Submission

## Zammad Integration

This app proxies ticket creation to your Zammad instance.
Configure the following admin settings in `config.php` or via app settings (server-side):
- `zammadapiticketsubmission.zammadUrl` – Base URL of your Zammad (e.g. `https://zammad.example.com`)
- `zammadapiticketsubmission.apiToken` – Personal Access Token created in Zammad with permission to create tickets.

The frontend posts to the OCS endpoint `/ocs/v2.php/apps/zammadapiticketsubmission/api/tickets` which the server relays to Zammad's REST API.
