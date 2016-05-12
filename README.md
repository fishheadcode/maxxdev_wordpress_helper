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

## Add jQuery to your project

```php
<?php addJQuery($specific_version, $addToFrontend, $addToBackend) ?>
```
option | default | value  | description
------ | ------- | -------|-------
$specific_version|null | | If you want to have a specific version of jquery enter the version number here. If you dont add a version it will be //code.jquery.com/jquery.min.js added
$addToFrontend |true | boolean | Should it be embedded in the frontend?
$addToFrontend |true | boolean | Should it be embedded in the backend?

## Add a JS File
It´s very easy to add a JS File
