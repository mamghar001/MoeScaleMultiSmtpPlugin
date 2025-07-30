# MoeScale Multi SMTP Bundle

This plugin provides dynamic SMTP rotation for Mautic v6. Outbound emails are distributed evenly across SMTP servers defined in the `smtp_servers` table.

## Installation
1. Copy the `MoeScaleMultiSmtpBundle` directory into Mautic's `/plugins` directory.
2. Run the following commands from the Mautic root:
   ```bash
   php bin/console cache:clear
   php bin/console mautic:plugins:reload
   ```
3. In **Configuration > Email Settings**, set the **Mailer DSN** to `multismtp://default` and save.
4. Add your SMTP server records into the `smtp_servers` table.

The plugin will automatically rotate between enabled SMTP servers on every email send.
