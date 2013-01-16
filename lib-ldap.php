<?php

/*
    Attempt to connect to LDAP server
    If successful       return connection string
    Otherwise           return false
*/
function my_ldap_connect(){
    global $ldap_server;
    
    // Connect to LDAP server
    $conn = ldap_connect($ldap_server['hostname'], $ldap_server['port']);
    if ($conn) {
        // Set Protocol Version
        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, $ldap_server['protocol_version']);
        
        // Bind to LDAP server
        $bind = my_ldap_bind($conn);
        
        if ($bind) {
            return $conn;
        }     
    }
    return false;
}

/* 
    Bind as user defined in settings.php
    
    @param resource LDAP connection resource
    
    If successful   return true
    Otherwise       return false
*/
function my_ldap_bind($conn){
    global $ldap_server;
    return ldap_bind($conn);
}

/*
    Search LDAP directory
    
    @param  resource    LDAP connection resource
    @param  string      LDAP search filter
    
    If successful       return array of data for first matching object
    Otherwise           return false
*/
function my_ldap_search($conn, $search_filter){
    global $ldap_server, $ldap_attributes;

    $ldap_searcher = ldap_search($conn, $ldap_server['base_dn'], $search_filter, array_keys($ldap_attributes));

    $search_result = ldap_get_entries($conn, $ldap_searcher);    
    $user_info = array();
    
    if ($search_result['count'] > 0){
        // Put info for first matching user in to array
        foreach ($ldap_attributes as $k => $v){
            if (isset( $search_result[0][strtolower($k)] ) ){ 
                    $user_info[$v] = $search_result[0][$k][0]; 
                }
        }    
    }
            
    return $user_info;
}


?>
