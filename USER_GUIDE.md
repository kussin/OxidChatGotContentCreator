# Kussin | ChatGPT Content Creator for OXID eShop

![OXID 6 Admin > Module > ChatGPT Content Creator > Main Tab](docs/img/Module_ChatGPT_Main.png)

Kussin | ChatGPT Content Creator for OXID eShop generates Content for Articles, Categories, Manufacturer and Vendors
based on provided data with the help of [ChatGPT](https://chat.openai.com/).<br>
The module comes with predefined Prompts for each type of Content, but you can also create your own Prompts inside the
OXID eShop Admin Panel.

Besides the recommended Process Queue, it's also possible to generate Content directly inside each Content Type.
Currently two options are available:

* **Create new Long Description**, which will generate a new Long Description based on the provided data (e.g. Object Title).
* **Create new Short Description**, which will generate a new Short Description based on the provided data (e.g. Object Title).

**NOTE:** The module requires a valid [OpenAI Subscription](https://platform.openai.com/) to work.

## Module Settings

![OXID 6 Admin > Module > ChatGPT Content Creator > Settings Tab](docs/img/Module_ChatGPT_Settings.png)

TODO: Will follow soon

### General Configuration

TODO: Will follow soon

## Process Queue

![OXID 6 Database > Table `kussin_chatgpt_content_creator_queue`](docs/img/Module_ChatGPT_Queue.png)

The USP of this module is the **Process Queue**, which allows you to create a large amount of Content based on SQL Statements.<br>
The module will simply process in the background 24/7 until the Queue is done. It's also possible that the Process Queue
automatically creates Content for new Articles, Categories, Manufacturer and Vendors, directly after they are created.

### Content Examples

![OXID 6 Admin > Manage Articles > Articles > Main Tab > WYSIWYG](docs/img/Module_ChatGPT_Description.png)

**NOTE:** All examples are Process Queue generated with a Custom Prompt.

* [Article - Long Description](docs/examples/oxartextends_oxlongdesc.html)

## Bugtracker and Feature Requests

Please use the [Github Issues](https://github.com/kussin/OxidChatGptContentCreator/issues) for bug reports and feature requests.

## Support

Kussin | eCommerce und Online-Marketing GmbH<br>
Fahltskamp 3<br>
25421 Pinneberg<br>
Germany

Fon: +49 (4101) 85868 - 0<br>
Email: info@kussin.de

## Copyright

&copy; 2006-2024 Kussin | eCommerce und Online-Marketing GmbH