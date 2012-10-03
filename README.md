ZendServer-CustomAuth
=====================

A custom authentication adapter example for Zend Server.
This zf2 module relies on the Zend Server GUI for operation and shows the basic structure and requirements for creating a new authentication adapter.

Integration
-----------
* Unpack the module into the gui/vendor directory
* Add the 'CustomAuth' module to the end the list of modules in gui/config/application.config.php
* Disable simple authentication in gui/config/zend_ui_user.ini:
 [authentication]
 simple = false
* Add the adapter name in gui/config/zend_ui_user.ini:
 [authentication]
 simple = false
 adapter = "CustomAuth\Adapter\AdapterWithGroups"

Notes for continued development
-------------------------------

The two provided CustomAuth adapter is a naive "always true" adapter that returns a successful result object for any input.
Branch this git repository and add functionality as needed.

CustomAuth\Authentication\Adapter\Adapter is a simple adapter that authenticates and returns a result object.
Note that at the end of the authentication process you should set a role for the identity ('administrator', 'developer', 'developerLimited')

CustomAuth\Authentication\Adapter\AdapterWithGroups shows an adapter that is also a groups provider. These groups are to be provided by the authentication process and are then used to map the user's permissions to his role and/or applications he has access to.