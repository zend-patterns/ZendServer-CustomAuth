# Zend Server Authentication

Zend Server provides two built-in authentication methods - "simple" and "extended". The first is the default one, and it provides 
only two users: "admin" and "developer". The users list is stored in the local SQLite database 
(or MySql on cluster). The latter, "extended", allows authentication through LDAP. Connection settings can be easily defined through 
Zend Server UI wizard.

Usually this is enough, but in edge special cases, or in some systems with special requirements, more sophisticated 
authentication needed. For this, we have the ability to extend the authentication system by implementing our own auth adapter. 
Since ZS is built on top of Zend Framework 2, authentication extension is made by creating standard ZF2 module with defined adapter.

## ZendServer-CustomAuth

This repo contains an example of authentication adapter, that works with list of users that are stored in a text file. The file contains rows 
with users' roles, usernames and hased passwords. The adapter use dedicated model, which interacts with the data file. So the module has configuration file, 
few object factories (dependency injection), authentication adapter, model and the data file.

## Integration

1. Create directory called `ZendServerCustomAuthModule` under `<ZS installation path>/gui/3rdparty` directory, and place the contents of this repository inside.
(`ZendServerCustomAuthModule` is the namespace of the module, therefore this must be the name of the directory)
2. Add the "ZendServerCustomAuthModule" module to the end of the modules list in `<ZS installation path>/gui/3rdparty/modules.config.php`
3. Open the file `<ZS installation path>/gui/config/zs_ui.ini` for editing, and modify two directives' values under `[authentication]` section

```
    [authentication]
    simple = false
    adapter = "ZendServerCustomAuthModule\Authentication\Adapter\Adapter"
```

Notes for continued development
-------------------------------

* This adapter demonstrates authentication by users that are stored in a file. This is just an example and **It is wrong and not secure to 
use it on production**. 

* The password is hashed using direct md5 without any applied salt, what makes it easier to decrypt the list by potential hackers.

* Since the users list is stored in a file, it cannot be used on a cluster. That is, because every machine has its own disk and the users list may vary from 
one node to another. More common way is to use a resource that all the nodes in the cluster have access to. For instance it may be MySql database 
or a shared secure folder.

* `CustomAuth\Authentication\Adapter\Adapter` is a simple adapter that authenticates and returns a result object.
Note that at the end of the authentication process you must set a role for the identity. Available roles are 'administrator', 'developer' and 'developerLimited'.
(The latter is not used in the example)
