# Kussin | ChatGPT Content Creator for OXID eShop

Kussin | ChatGPT Content Creator for OXID eShop generates Content for Articles, Categories, Manufacturer and Vendors 
based on provided data with the help of [ChatGPT](https://chat.openai.com/).<br>
The module comes with predefined Prompts for each type of Content, but you can also create your own Prompts inside the
OXID eShop Admin Panel.

**NOTE:** The module requires a valid [OpenAI Subscription](https://platform.openai.com/) to work.

The USP of this module is the **Process Queue**, which allows you to create a large amount of Content based on SQL Statements.<br>
The module will simply process in the background 24/7 until the Queue is done. It's also possible that the Process Queue
automatically creates Content for new Articles, Categories, Manufacturer and Vendors, directly after they are created.
(CMS Pages are not supported yet, but [planed for I/2024](https://github.com/kussin/OxidChatGptContentCreator/issues/8).

**NOTE:** By default, the module uses the [OpenAI Model](https://platform.openai.com/docs/models) [`gpt-3.5-turbo-instruct`](https://platform.openai.com/docs/models/gpt-3-5) 
but you can change it to any other Model in the Admin Panel.

## Requirement

1. OXID eSales CE/PE/EE v6.2.5 or newer
2. PHP 7.4 or newer

## Installation Guide

### Initial Installation

To install the module, please execute the following commands in OXID eShop root directory:

   ```bash
   composer config repositories.kussin_chatgpt vcs https://github.com/kussin/OxidChatGptContentCreator.git
   composer require "kussin/chatgpt-content-creator":"dev-dev" --no-update
   composer clearcache
   composer update --no-interaction
   vendor/bin/oe-console oe:module:install-configuration source/modules/kussin/chatgpt-content-creator/
   vendor/bin/oe-console oe:module:apply-configuration
   ```

**NOTE:** If you are using VCS like GIT for your project, you should add the following path to your `.gitignore` file:
`/source/modules/kussin/`

## User Guide

[User Guide](USER_GUIDE.md)

## Bugtracker and Feature Requests

Please use the [Github Issues](https://github.com/kussin/OxidChatGptContentCreator/issues) for bug reports and feature requests.

## Support

Kussin | eCommerce und Online-Marketing GmbH<br>
Fahltskamp 3<br>
25421 Pinneberg<br>
Germany

Fon: +49 (4101) 85868 - 0<br>
Email: info@kussin.de

## Licence

[End-User Software License Agreement](LICENSE.md)

## Credits

* [Radu Lepadatu](https://github.com/Radulepy) for creating [`Radulepy/PHP-ChatGPT`](hhttps://github.com/Radulepy/PHP-ChatGPT/)

## Copyright

&copy; 2006-2024 Kussin | eCommerce und Online-Marketing GmbH