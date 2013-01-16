<?php

/********************************
Raplet Meta Data
Settings to describe the Raplet

$rapplet_meta['name']                   Raplet name
$rapplet_meta['description']            Raplet description (HTML Permitted)
$rapplet_meta['welcome_text']           Welcome text displayed to user (HTML Permitted)
$rapplet_meta['icon_url']               URL of icon (100x100 px)
$rapplet_meta['preview_url']            URL of preview image (220px wide)
$rapplet_meta['config_url']             URL of login page (ldap-login.php)
$rapplet_meta['provider_name']          Raplet provider organization name
$rapplet_meta['provider_url']           Raplet provider organization URL
$rapplet_meta['data_provider_name']     Raplet data provider name (Optional)
$rapplet_meta['data_provider_url']      Raplet data provider URL (Optional)

********************************/
$rapplet_meta['name']               = "MIT Directory";
$rapplet_meta['description']        = "Information from MIT's public LDAP directory, including office address, department, phone number, etc.";
$rapplet_meta['welcome_text']       = "Thanks for using MIT Directory Raplet. For support, email raplet@mit.edu.";
$rapplet_meta['icon_url']           = "https://grinich.scripts.mit.edu/ldap-raplet/icon.png";
$rapplet_meta['small_icon_url']		= "https://grinich.scripts.mit.edu/ldap-raplet/mit-favicon.gif";
$rapplet_meta['preview_url']        = "https://grinich.scripts.mit.edu/ldap-raplet/preview.png";
$rapplet_meta['config_url']         = "";
$rapplet_meta['provider_name']      = "Michael Grinich";
$rapplet_meta['provider_url']       = "mailto:mg@mit.edu";
$rapplet_meta['data_provider_name'] = "MIT Public LDAP (raplet@mit.edu)";
$rapplet_meta['data_provider_url']  = "mailto:raplet@mit.edu";


/********************************
LDAP Server Settings

$ldap_server['hostname']            LDAP Server Hostname or IP
$ldap_server['port']                LDAP Server Port
$ldap_server['bind_rdn']            Bind User Fully Qualified DN
$ldap_server['bind_pass']           Bind User Password
$ldap_server['base_dn']             Search Base
$ldap_server['username_attribute']  Attribute for the object username
$ldap_server['token_attribute']     Attribute for the oAuth token string
$ldap_server['protocol_version']    LDAP Protocol Version

********************************/
$ldap_server['hostname']            = "ldap-too.mit.edu";
$ldap_server['port']                = "389";
$ldap_server['bind_rdn']            = "";
$ldap_server['bind_pass']           = "";
$ldap_server['base_dn']             = "dc=mit,dc=edu";
$ldap_server['username_attribute']  = "uid";
$ldap_server['token_attribute']     = "uid";
$ldap_server['protocol_version']    = 3;

/********************************

Array of attributes to return.
Key is attribute name (lowercase), value is label displayed to user.
Elements listed in display order.

********************************/
$ldap_attributes = array (
        'displayname'       => 'Name',
        'roomnumber'		=> 'Room',
        'telephonenumber'   => 'Tel',
        'o'                 => 'Organization',
        'title'             => 'Title',
        'ou'                => 'Department',
        'mail'              => 'Email',
        'mobile'            => 'Mob',
        'labeleduri'		=> 'Web',
        'uid'				=> 'Kerberos',
        'mitdirstudentyear'	=> 'Year',
        'homedirectory'		=> "Home Directory",
        'street'			=> "Street",

    );



?>
