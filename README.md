dokuwiki-authmkpop3
===================

DokuWiki - Provides authentication against POP3

Modify your *conf/local.php* :

>$conf['authtype'] = 'authmkpop3';<br />
>$conf['plugin']['authmkpop3']['authserver'] = '{your.host:110/pop3}';

Create folder *lib/plugins/authmkpop3*

Copy *plugin.info.txt* and *auth.php* to this folder

Source : https://forum.dokuwiki.org/post/38742
