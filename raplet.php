<?php

include_once('settings.php');
include_once('lib-ldap.php');

$get_data['email']              = (isset($_GET['email']))               ? $_GET['email'] : "";
$get_data['name']               = (isset($_GET['name']))                ? $_GET['name'] : "";
$get_data['twitter_username']   = (isset($_GET['twitter_username']))    ? $_GET['twitter_username'] : "";
$get_data['callback']           = (isset($_GET['callback']))            ? $_GET['callback'] : "";
$get_data['show']               = (isset($_GET['show']))                ? $_GET['show'] : "";

if ($get_data['show'] == "metadata") // Raplet metadata query
{
    // Required metadata values
    $json_data['name']          = $rapplet_meta['name'];
    $json_data['description']   = $rapplet_meta['description'];
    $json_data['welcome_text']  = $rapplet_meta['welcome_text'];
    $json_data['icon_url']      = $rapplet_meta['icon_url'];
    $json_data['config_url']    = $rapplet_meta['config_url'];
    $json_data['preview_url']   = $rapplet_meta['preview_url'];
    $json_data['provider_name'] = $rapplet_meta['provider_name'];
    $json_data['provider_url']  = $rapplet_meta['provider_url'];

    // Optional metadata values
    if ($rapplet_meta['data_provider_name'] != "")  $json_data['data_provider_name'] = $rapplet_meta['data_provider_name'];
    if ($rapplet_meta['data_provider_url'] != "")   $json_data['dat_provider_url']   = $rapplet_meta['data_provider_url'];

} else {  // Query for user information

    // Found_info flag defaults to true
    $found_info = true;

    $conn = my_ldap_connect();
    
    // If connected to server and provided valid token
    if (is_resource($conn) ) {
        // Search for users with matching email address    
        $search_result = [];

        // Make sure root of email is mit.edu
        // if ( substr($get_data['email'], -7, 7) == "mit.edu") {

            // Search first by email
            if ( strlen( $get_data['email'] ) > 0) {
               $search_result = my_ldap_search($conn, "mail=".$get_data['email']);
            }

            // Then by name
            if (count($search_result) == 0) {
                if ( strlen( $get_data['name'] ) > 0) {
                    $search_result = my_ldap_search($conn, "cn=".str_replace(' ', '*', $get_data['name']) );
                }
            }
        // }

        // No matching users found
        if (count($search_result) == 0) { 
            $found_info = false; 
        }        
    } else {

        // Bind to LDAP server failed
        $found_info = false;
    }

    // If user information has been found...
    if ($found_info){

        $html = ""; 

        // Name and link to homepage
        $name_string = $search_result["Name"];
        $middle = '<div class="icon"><img src="mit_favicon.gif"></div>' . $name_string;
        if ( array_key_exists("Web", $search_result) ) {
            $web_url = $search_result["Web"];

            $html = $html."<a class='profile-found' href=\"" . htmlspecialchars($web_url). "\" target='_blank' title='' site_name='MIT'>" . $middle . "</a>";
        } else if ( array_key_exists("Home Directory", $search_result) ) {
            $web_url = "http://web.mit.edu" .htmlspecialchars($search_result["Home Directory"]) . "/www/";
            $html = $html."<a class='profile-found' href=\"" . htmlspecialchars($web_url). "\" target='_blank' title='' site_name='MIT'>" . $middle . "</a>";
        } else {
            $html = $html . $middle;
        }
        $html = $html."<ul>";

        // Department title
        if ( array_key_exists("Title", $search_result) ) {
           $html = $html."<li>" . htmlspecialchars($search_result["Title"]). "</li>";
        }

        // Year (for students)
        if ( array_key_exists("Year", $search_result) ) {
           $html = $html."<li>Year: " . htmlspecialchars($search_result["Year"]). "</li>";
        }

        // Department (ie: Electrical Eng & Computer Science)
        if ( array_key_exists("Department", $search_result) ) {
            $department_lower = mb_convert_case($search_result["Department"], MB_CASE_TITLE, 'utf-8');
           $html = $html."<li>" . htmlspecialchars($department_lower). "</li>";

        }

        // Office address
        if ( array_key_exists("Room", $search_result) ) {
            $html = $html."<li>"."<a href=\"http://whereis.mit.edu/?q=" . htmlspecialchars($search_result["Room"]). "\">". htmlspecialchars($search_result["Room"]) . "</a></li>";
        }

        // Street (home) address
        if ( array_key_exists("Street", $search_result) ) {
            $html = $html."<li>"
            . "<a href=\"https://maps.google.com/maps?q=" 
            . htmlspecialchars( $search_result["Street"] ) 
            . "\">". htmlspecialchars($search_result["Street"]) 
            . "</a></li>";
        }

        // Telephone number (likely office)
        if ( array_key_exists("Tel", $search_result) ) {
            $html = $html."<li><a href=\"tel:" . htmlspecialchars($search_result["Tel"]). "\">" . htmlspecialchars($search_result["Tel"]) . "</a></li>";
        }


        $html = $html."</ul>";
        $status = 200; // OK
        
    } else {
        // No user found
        $html = "";
        $status = 404;
    }

    $css = file_get_contents('style.css');
    $js = ""; // Not dynamic

    $json_data = array('html'=>$html, 'css'=>$css, 'js'=>$js, 'status'=>$status);

    $log_this = date("Y-m-d H:i:s") .",". $get_data['name'] .",". $get_data['email'] . "\n";

    file_put_contents("./mylog.txt",  $log_this ,  FILE_APPEND  |  LOCK_EX );



}

// Repair escape slash bug in json_encode()
// http://bugs.php.net/bug.php?id=49366
$json_return = str_replace('\\/', '/', json_encode($json_data));

header('Content-type: text/javascript');

// Return Callback and JSON for Rapportive
echo $get_data['callback']."(".$json_return.")";

?>
