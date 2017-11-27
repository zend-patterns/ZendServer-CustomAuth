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
(`ZendServerCustomAuthModule` is the namespace of the module, therefore this must be the name of the directory). This can be done in one "git clone" command: 
`# sudo git clone https://github.com/zend-patterns/ZendServer-CustomAuth.git /usr/local/zend/gui/3rdparty/ZendServerCustomAuthModule`

2. The downloaded module has to be integrated into the system. 
Add the "ZendServerCustomAuthModule" module to the end of the modules list in `<ZS installation path>/gui/3rdparty/modules.config.php`

3. Edit the file `<ZS installation path>/gui/config/zs_ui.ini`, and modify two directives - "simple" and "adapter" under `[authentication]` section

```
    [authentication]
    simple = false
    adapter = "ZendServerCustomAuthModule\Authentication\Adapter\Adapter"
```


## Fallback

When something goes wrong and the authentication fails, there is always a way to reset the settings. To do so please follow the next steps:

#### For Windows users
1. Open your Start menu, and select Zend Server from the Programs list.

2. Click Change Password.
> **Important!** On Windows 7 or above, run the utility with admin permissions: right-click _Change Password_, and select _Run as Administrator_.
The Change Password CLI is displayed.

3. Enter a new password, and press **Enter**.
You are asked to confirm your action.

4. Enter 'y', and press **Enter**.
Your password is reset, and can be used the next time you log in to the Zend Server UI.

#### Linux and Mac OS X:
From the command line, run the following command **as root**:
```
$ /usr/local/zend/bin/php /usr/local/zend/bin/gui_passwd.php <your new password>
```
Your password is reset, and can be used the next time you log in to the Zend Server UI.

If you are unable to change your password, refer to the [Support Center](http://www.zend.com/en/support-center/support) for further information.

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
