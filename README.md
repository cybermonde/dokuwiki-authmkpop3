dokuwiki-authmkpop3
===================

DokuWiki - Provides authentication against POP3

Modify your local.php :

$conf['authtype'] = 'authmkpop3';<br />
$conf['plugin']['authmkpop3']['authserver'] = '{your.host:110/pop3}';

Source : https://forum.dokuwiki.org/post/38742
