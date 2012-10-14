ZendServer-CustomAuth
=====================

A custom authentication adapter example for Zend Server 6.
This zf2 module relies on the Zend Server GUI for operation and shows the basic structure and requirements for creating a new authentication adapter.

Integration
-----------
* Unpack the module into the gui/vendor/CustomAuth directory, note that you may have to rename the directory the zip file unpacks to.
* Add the 'CustomAuth' module to the end the list of modules in gui/config/application.config.php
* Disable simple authentication in gui/config/zend_ui_user.ini:


        [authentication]
        simple = false


* Add the adapter name in gui/config/zend_ui_user.ini:


        [authentication]
        simple = false
        adapter = "CustomAuth\Authentication\Adapter\Adapter"

If you are going to use the AdapterWithGroups class: open the var/db/gui.db file using an sqlite3 client and run the following query

        INSERT INTO GUI_LDAP_GROUPS (NAME, LDAP_GROUP, LINK_TYPE) VALUES('administrator', 'administrators', 1);

Note that you will have a UI to edit and add groups once inside the UI, you will just need this one group set up to get inside the UI on the first time.
Should you modify the provided class and derive groups that are not hard-coded, this query will probably have to be replaced or completely dropped.

Notes for continued development
-------------------------------

The two provided CustomAuth adapter is a naive "always true" adapter that returns a successful result object for any input.
Branch this git repository and add functionality as needed.

CustomAuth\Authentication\Adapter\Adapter is a simple adapter that authenticates and returns a result object.
Note that at the end of the authentication process you should set a role for the identity ('administrator', 'developer', 'developerLimited')

CustomAuth\Authentication\Adapter\AdapterWithGroups shows an adapter that is also a groups provider. These groups are to be provided by the authentication process and are then used to map the user's permissions to his role and/or applications he has access to.