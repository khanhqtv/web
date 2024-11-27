<?php
function check_format($userInput) {
    $pattern='/^[A-Za-z0-9_-]{3,20}$/';
    if (preg_match($pattern, $userInput)) { 
        return true;
    }
    echo 'lỗi tên đăng nhập';
    return false;
}
function detectSQLi($userInput) {
    $SQLi_pattern = "/(delete|’|substring|SELECT|INSERT)/i";
    if (preg_match($SQLi_pattern, $userInput)) {
        echo "lỗi sql";
        return false;
    }
}

function detectXSS($userInput) {
    $xss_pattern = "/(<script>|<\/script>|alert|')/i";   
    if (preg_match($xss_pattern, $userInput)) {
        echo "lỗi xss";
        return false;
    }
}

function remove_xss2($input)
{
    $pattern='/<.*?>/';
    return preg_replace($pattern, '', $input);
}
function detect_sql2($input)
{
    $pattern='/delete|select|insert|--/i';
    if(preg_match($pattern,$input))
    {
        return true;
    } else
    {
        return false;
    }
        
}

function remove_xss($input)
{
    $pattern='/<.*?>/';
    return preg_replace($pattern,'',$input);
}

function detect_sql($input)
{
    $pattern='/delete|insert|select|--/i';
    if(preg_match($pattern,$input))
    {
        return true;
    }
}
?>