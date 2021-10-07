# Postmark driver for OctoberCMS
[Postmark](https://postmarkapp.com/)  delivers your transactional email to customers on time, every time.

## Requirements
This package install `coconutcraig/laravel-postmark` as a mail transport for OctoberCMS

First all, create an account on Postmark, it is required to be used on your platform.

## Installation
### From composer:
```bash
composer require planetadeleste/postmarkdriver-plugin
```

### From OctoberCMS marketplace
Add [plugin](https://octobercms.com/plugin/planetadeleste-postmarkdriver)  to your project

### From OctoberCMS command line

```bash
php artisan october:install planetadeleste.postmarkdriver
```

## Configuration
- In your OctoberCMS, go to "Settings" > "Mail configuration"
- Select from the mail method "Postmark"
- Write your Postmark server API token
- Save and start to use postmark to send your emails