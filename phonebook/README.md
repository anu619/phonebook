CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Troubleshooting
 * FAQ


## INTRODUCTION
------------

The phonebook module provides stored the Name, Phone number, Email Id, and logged user details.

Used a Custom path for all user roles. Admininstrator can configure which role can create the phonebook entry.

Phonebook module beneficial for creating additional customer details.

## REQUIREMENTS
------------

This module requires no other modules


## INSTALLATION
------------

 * Install as you would normally install a Custom Drupal module. For further
information, see(https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).After installing "phonebook" table created into the database.


## CONFIGURATION
-------------

 1. Enable the module at Administration > Extend.
 2. Enable the permission "Phonebook entry add".
 3. Add the Url into the browser (phonebook/add).
 4. Fill out "Name", "Email", "Phone number".
 5. Click "Save" to save your phonebook entry. When you save a new phonebook, it
    will be stored in the "phonebook" table in the database.


## TROUBLESHOOTING
---------------

If the URL does not display, check the following:

- Check the "Phonebook entry add" permission enabled for the appropriate roles?


## FAQ

**Q: I am getting website encounter error when save the data.

**A:** Please check in log messages page and checked the type "phonebook".

