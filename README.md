dokuwiki-authmkpop3
===================

DokuWiki - Provides authentication against POP3

Modify your *conf/local.php* :

>$conf['authtype'] = 'authmkpop3';<br />
>$conf['plugin']['authmkpop3']['authserver'] = '{your.host:110/pop3}';

Create folder *lib/plugins/authmkpop3*

Copy *plugin.info.txt* and *auth.php* to this folder

Create users 
- by hand : username is e-mail and no password **or** 
- create a script to generate a *conf/users.auth.php*

Source : https://forum.dokuwiki.org/post/38742

Tested under : Release 2013-05-10a "Weatherwax"
