<?php 
function user_login_ldap($username, $password) {
	$ldapsrv=''; // set your LDAP servers IP address (ex.192.168.0.1)
	$ldapsrv_domain=''; // set your LDAP servers Domain
	$ldaperr['525']='User not found';
	$ldaperr['52e']='Invalid credentials';
	$ldaperr['530']='Not permitted to logon at this time';
	$ldaperr['531']='Not permitted to logon at this workstation';
	$ldaperr['532']='Password expired';
	$ldaperr['533']='Account disabled';
	$ldaperr['701']='Account expired';
	$ldaperr['773']='User must reset password';
	$ldaperr['775']='User account locked';
	if (!$ds=ldap_connect($ldapsrv)) {
		return 'Unable to connect to LDAP server';
	}else {
		ldap_set_option($ds,LDAP_OPT_PROTOCOL_VERSION,3);
		ldap_set_option($ds,LDAP_OPT_REFERRALS,0);
		if ($ger=@ldap_bind($ds,$username.'@'.$ldapsrv_domain,$password)) {
			return true;
		} else {
			ldap_get_option($ds, LDAP_OPT_ERROR_STRING, $diagmsg);
			if (isset($diagmsg)) $diagmsg2 = explode(',', $diagmsg);
			if (isset($diagmsg2) and preg_match('/data (.*)/i', trim($diagmsg2[2]),$res2) and isset($ldaperr[$res2[1]])) return $ldaperr[$res2[1]];
			else return ldap_error($ds);
	}
	ldap_close($ds);
	}
}
 ?>
