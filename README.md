# MoeScaleMultiSmtpPlugin


This project is a Mautic plugin designed to evenly distribute outgoing emails across multiple SMTP servers, inspired by the `MauticEvenlyDistributesSmtpBundle`.

**Compatibility:** This plugin is intended for Mautic v6.

## Purpose

The goal is to:
- Evenly distribute email sending load across multiple SMTP servers
- Use database logic to determine which SMTP server to use for each email
- Improve deliverability and scalability for Mautic users with high email volumes

## Features
- Automatic rotation of SMTP servers for outgoing emails
- Configuration interface for managing SMTP server details
- Database integration to track and balance usage
- Seamless integration with Mautic's email sending workflow

## Status
This repository contains the source code of the **MoeScale Multi SMTP Bundle**.
Copy the `MoeScaleMultiSmtpBundle` directory from this repo into your Mautic
`plugins` directory and run `php bin/console cache:clear` followed by
`php bin/console mautic:plugins:reload`.

In Mautic's configuration set the **Mailer DSN** to `multismtp://default`.
Add your SMTP server details into the `smtp_servers` table and emails will be
evenly rotated across them.

## Inspiration
Inspired by the `MauticEvenlyDistributesSmtpBundle`, this plugin aims to provide a scalable, database-driven approach to SMTP server distribution in Mautic.

## License
MIT

