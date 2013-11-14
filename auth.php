<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * POP3/IMAP authentication plugin for DokuWiki
 *     copyright (c) by moto kawasaki <moto@kawasaki3.org>
 *
 * @license     Choose one of FreeBSD or GPL3.
 *              FreeBSD (http://www.freebsd.org/copyright/freebsd-license.html)
 *              GPL3    (http://www.gnu.org/licenses/gpl.html)
 * @author      moto kawasaki <moto@kawasaki3.org>
 */

// You need to choose this plugin as authtype in $DOKU_ROOT/conf/local.php.
//     $conf['authtype'] = 'authmkpop3';
// Also you may need to set authserver parameter.
// This is the first argument 'string $mailbox' for imap_open().
//     $conf['plugin']['authmkpop3']['authserver'] = '{10.200.246.4:995/pop3/ssl/novalidate-cert}';
// authserver has default value of '{127.0.0.1:110/pop3}'. See ./conf/default.php
//
// Then, create/modify/delete DokuWiki users in Admin Panel, except for
// the password which is stored in POP3/IMAP server side and thus you cannot
// store/modify at the DokuWiki side.
//
// authmkpop3 tries to connect $authserver using imap_open(),
// and $user + $passwd taken from user input at the login panel,
// and return true/false accroding to the result of POP3/IMAP authentication.
//
// Please note that authmkpop3 is extended from authplain, so most features of
// the authplain plugin are available in authmkpop3 too.
// The major differences are 1) configuration parameters and 2) inability on
// the passwd described above.

class auth_plugin_authmkpop3 extends auth_plugin_authplain {

    protected $server = null; // expects string $mailbox for imap_open().

    public function __construct() {
        parent::__construct();

        if(!function_exists('imap_open')) {
            $this->debug("authmkpop3 err: PHP IMAP extension not found.", -1, __LINE__, __FILE__);
            $this->sucess = false;
            return;
        }

        if(!($this->server = $this->getConf('authserver'))) {
            $this->debug("authmkpop3 err: insufficient configuration.", -1, __LINE__, __FILE__);
            $this->success = false;
            return;
        }

        $this->cando['addUser']      = true;
        $this->cando['delUser']      = true;
        $this->cando['modLogin']     = true;
        $this->cando['modPass']      = false;
        $this->cando['modName']      = true;
        $this->cando['modMail']      = true;
        $this->cando['modGroups']    = true;
        $this->cando['getUsers']     = true;
        $this->cando['getUserCount'] = true;
        $this->cando['GetGroups']    = true;
        $this->cando['external']     = false;
        $this->cando['logout']       = true;

        $this->success = true;
        return;
    }

    public function checkPass($user, $pass) {

		// hack by cybermonde.org : dokuwiki replace the "@" contained in the username with "_"
		// begin
		$userarobase = str_replace("_", "@", $user);		
		// end

        $userinfo = $this->getUserData($user);
        if ($userinfo == false) {
            sleep(8);
            return false;
        }

        if (!($handle = imap_open($this->server, $userarobase, $pass))) {
            return false;
        } else {
            imap_close($handle);
        }
        return true;
    }
}
