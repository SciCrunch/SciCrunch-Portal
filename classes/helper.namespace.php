<?php
namespace helper;


function formattedDescription($text){
    return str_replace("\\\\n", "<br/>", $text);
}

function writeEachMessage($message){
    $return_msg = "";
    foreach($message as $msg){
        $return_msg .= '<tr><td valign="top">' . $msg . '</td></tr>';
    }
    return $return_msg;
}

function buildEmailMessage($message, $alt=0, $data = NULL){
    ob_start();	// starts reading output into buffer.  allows for html in a function
    include $_SERVER['DOCUMENT_ROOT'] . '/email.php';
    $new_message = ob_get_clean();	// push ouput and stop using the buffer
    return $new_message;
}

function sendEmail($to, $message, $subject, $from = NULL, $cc = NULL, $alt=0, $data = NULL){
    $email_message = \helper\buildEmailMessage($message, $alt, $data);
    $email_to = implode(',', $to);

    $headers = "";
    $headers .= "MIME-Version: 1.0 \r\n";
    $headers .= "Content-type:text/html;charset=UTF-8 \r\n";
    $headers .= "From: SciCrunch <no-reply@scicrunch.org> \r\n";
    if($cc) $headers .= implode(",", $cc);
    if($from) $headers .= "Reply-To:".$from."\r\n";

    $return = mail($email_to, $subject, $email_message, $headers);
    return $return;
}

function checkLongURL($data){
    if(substr($data, 0, 2) != "<a") return $data;   // make sure it's an anchor tag
    $ncbi_url = "http://www.ncbi.nlm.nih.gov/pubmed/";

    try{
        $a = new \SimpleXMLElement($data);
        $href = (string) $a['href'];
        if(strlen($href) > strlen($ncbi_url) && substr($href, 0, strlen($ncbi_url)) == $ncbi_url){
            $href_trim = ltrim($href, $ncbi_url);
            $href_array = \helper\splitLongURL($href_trim);
            $url_array = Array();
            foreach($href_array as $i => $usable_href){
                $count_val = count(explode(" ", $usable_href));
                $pmid_str = $count_val > 1 ? "PMIDs" : "PMID";
                $url = '<a href="' . $ncbi_url . $usable_href . '">' . $pmid_str . ' (' . $count_val . ')</a>';
                array_push($url_array, $url);
            }
            $final_url = implode(" ", $url_array);
            return $final_url;
        }else{
            return $data;
        }
    }catch(\Exception $e){
        return $data;
    }
}

function splitLongURL($data){
    $max_length = 7000;
    if(strlen($data) > $max_length){
        $href_array = explode(",", $data);
        $half_point = (int) (count($href_array) / 2);
        $left_half = \helper\splitLongURL(implode(",", array_slice($href_array, 0, $half_point)));
        $right_half = \helper\splitLongURL(implode(",", array_slice($href_array, $half_point, count($href_array) - 1)));
        $merged = array_merge($left_half, $right_half);
        return $merged;
    }else{
        return Array($data);
    }
}

function noscriptHTML(){
    ob_start(); ?>

    <noscript>
        <div class="alert alert-danger">
            SciCrunch relies heavily on JavaScript.  Many functions on the site will not work if you continue with JavaScript disabled.
        </div>
    </noscript>

    <?php return ob_get_clean();
}
?>
