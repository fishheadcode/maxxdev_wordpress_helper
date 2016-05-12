#maxxdev_wordpress_helper
Made with :heart: by [Chris Schrut](https://twitter.com/chrisschrut)!

## Features
### Frontend
- Add a JS File
  - jQuery
  - Custom File
- Add a CSS File
- Add/Install a Frontend Framework
  - Bootstrap
  - FontAwesome
  - Bootswatch
  
### Admin & Wordpress Backend
- Add a meta box
- Add a toplevel menu
- Add a toplevel submenu
- Add a options page
 
### Date
- Get german days
- Get german months

### Mail
- Set the reciever(s)
- Set the subject of the email
- Set the "from"-property in the header
- Set the message of the mail
- Add an attachment to the email

### Media
- Add a thumbnail size
- Add media from path

### Pages
- Add/Create a page
- Set a pagetemplate 
- Get a page by title
- Get the page content by title

### Posttype
- Add a custom post type 
- Add a taxonomy

### User
- Create a user
- Login helper
- Autologin functionality

### Todos
- Search a user
- Delete a user
- Set role for a user

## Installation
- Download/Clone this repo in your Wordpress Plugins folder.
- Activate the Plugin

Now you can create a plugin where you can put all your changes with this helper in an action("init")-hook or just simply write it into the functions.php in your themes folder.

=============================

## Add jQuery to your project

```php
<?php Maxxdev_Helper_Frontend::addJQuery($specific_version, $addToFrontend, $addToBackend) ?>
```
option | default | value  | requierd | description
------ | ------- | -------|--------- | -----------
$specific_version|null |string|No| If you want to have a specific version of jquery enter the version number here. If you dont add a version it will be [//code.jquery.com/jquery.min.js](//code.jquery.com/jquery.min.js) added
$addToFrontend |true | boolean |No|Should it be embedded in the frontend?
$addToFrontend |true | boolean |No|Should it be embedded in the backend?

## Add a custom JS file
It´s very easy to add a JS File
```php
<?php Maxxdev_Helper_Frontend::addJs($file_path, $script_name, $addToFrontend, $addToBackend) ?>
```
option | default | value | requierd | description
------ | ------- | ----- | -------- | -----------
$file_path | - |string|Yes|The filepath of the JS file
$script_name |null|string|No|The name/handler of the script
$addToFrontend|true|boolean|No|Should it be embedded in the frontend?
$addToBackend|true|boolean|No|Should it be embedded in the backend?

## Add a custom CSS file
```php
<?php Maxxdev_Helper_Frontend::addCSS($file_path, $style_name, $addToFrontend, $addToBackend) ?>
```
option | default | value | requierd | description
------ | ------- | ----- | -------- | -----------
$file_path | - |string|Yes|The filepath of the CSS file
$script_name |null|string|No|The name/handler of the style
$addToFrontend|true|boolean|No|Should it be embedded in the frontend?
$addToBackend|true|boolean|No|Should it be embedded in the backend?

## Add/Install a Frontend Framework

Add **twitter Bootstrap** to your project

```php
<?php Maxxdev_Helper_Frontend::addBootstrap($specific_version, $load_css, $load_javascript, $addToFrontend, $addToBackend); ?>
```
option | default | value | requierd | description
------ | ------- | ----- | -------- | -----------
$specific_version|3.2.0|string|no|Specify the version here. Default: 3.2.0
$load_css|true|boolean|no|should the css from twitter bootstrap been loaded?
$load_js|false|boolean|no|should the js from twitter bootstrap been loaded?
$addToFrontend|true|boolean|No|Should it be embedded in the frontend?
$addToBackend|true|boolean|No|Should it be embedded in the backend?

Add **FontAwesome** to your project

```php
<?php Maxxdev_Helper_Frontend::addFontAwesome($specific_version, $addToFrontend, $addToBackend); ?>
```
option | default | value | requierd | description
------ | ------- | ----- | -------- | -----------
$specific_version|4.1.0|string|no|Specify the version here. Default: 4.1.0
$addToFrontend|true|boolean|No|Should it be embedded in the frontend?
$addToBackend|true|boolean|No|Should it be embedded in the backend?

Adds **bootswatch** to your site

**Valid themes:** 
- amelia 
- cerulean
- cosmo
- cyborg
- darkly
- flatly
- journal
- lumen
- readable
- simplex
- slate
- spacelab
- superhero
- united
- yeti

```php
<?php Maxxdev_Helper_Frontend::addBootswatch($theme,$specific_version, $addToFrontend, $addToBackend); ?>
```
option | default | value | requierd | description
------ | ------- | ----- | -------- | -----------
$theme|"amelia"|string|no|Name of the theme which should be added. Must be a valid bootswatch theme.
$specific_version|3.2.0|string|no|Specify the version here. Default: 3.2.0
$addToFrontend|true|boolean|No|Should it be embedded in the frontend?
$addToBackend|true|boolean|No|Should it be embedded in the backend?

## Add a meta box

Creates a new metabox in the admin area for the specified posttypes.

```php
<?php Maxxdev_Helper_Admin::addAdminMetaBox($screens, $section_id, $section_title, $section_title_translate_key, $callback_function); ?>

