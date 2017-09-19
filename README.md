# Zend Server Authentication

Zend Server provides two built-in authentication systems. the first one is called "simple", it provides
only two users - "administrator" and "developer". Their information is stored in the local database 
(or on MySql server in case of a cluster). The second method is called "extended", and it allows the 
system to be connected and authenticated via LDAP. The connection settings can be easily defined through 
the UI of Zend Server.

In most of the cases, these two methods are enough. However, there are some edge cases or some systems with special 
requirements that require more sophisticated authentication systems. For those, we have the possibility to extend 
the authentication system. Since ZS is built on top of Zend Framework 2, we will use ZF2 module to create our
own adapters and models

## ZendServer-CustomAuth

The authentication on the server is made through ZF2 auth adapters, which can be extended and manually implemented to fit system requirements. 
This repository contains an example of authentication adapter, that works with list of users that are stored in a text file. The file contains rows 
with users' roles, usernames and hased passwords.


## Integration

1. Create directory called `ZendServerCustomAuthModule` under `<ZS installation path>/gui/3rdparty` directory, and place the contents of this repository inside.
(`ZendServerCustomAuthModule` is the namespace of the module, therefore the directory should be called the same)
2. Add the "ZendServerCustomAuthModule" module to the end the list of modules in `<ZS installation path>/gui/3rdparty/modules.config.php`
3. Open the file `<ZS installation path>/gui/config/zs_ui.ini` for editing, and change two directives under `[authentication]` section

```
    [authentication]
    simple = false
    adapter = "ZendServerCustomAuthModule\Authentication\Adapter\Adapter"
```

Notes for continued development
-------------------------------

* This adapter demonstrates authentication by users that are stored in a file, of course this is just an example. **It is wrong and not secure to 
use it on production**. 

* The password is hashed using direct md5 without any applied salt, what makes it easier to decrypt the list by potential hackers.

* Since the users list is stored in a file, it cannot be used on a cluster, because every machine has its own disk, and the list may vary from 
one node to another. The more common way in this case, would be to use one database which is used by all the nodes in the cluster.

* `CustomAuth\Authentication\Adapter\Adapter` is a simple adapter that authenticates and returns a result object.
Note that at the end of the authentication process you must set a role for the identity. Available roles are 'administrator', 'developer' and 'developerLimited'.
(The latter is not used in the example)
