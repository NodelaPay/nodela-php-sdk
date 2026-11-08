# Recurring billing

Use `Client::$billing` to create customers and subscriptions, record usage, read subscriptions, invoices and mandates, and call checkout session operations with a session-scoped client secret.

The account API key belongs on your server. Only the checkout session ID and client secret should be passed to a payer-facing application.
