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
Work in progress. Contributions and suggestions are welcome!

## Getting Started
1. Clone this repository
2. Follow the instructions (to be added) for installing the plugin into your Mautic instance

## Inspiration
Inspired by the `MauticEvenlyDistributesSmtpBundle`, this plugin aims to provide a scalable, database-driven approach to SMTP server distribution in Mautic.

## License
MIT