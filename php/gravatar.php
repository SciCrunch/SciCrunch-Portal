<?php

function get_gravatar($email,$s = 300, $d = 'identicon', $r = 'g', $img = false, $atts = array()) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

$name = filter_var($_GET['name'],FILTER_SANITIZE_STRING);
echo get_gravatar($name.'@scicrunch.com',50,'identicon','g',true);

?>