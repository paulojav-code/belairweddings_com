<?php
    if(!isset($_COOKIE['BAUC_LANGUAGE_COOKIES'])){
        $data_info = @file_get_contents("https://api.ipquery.io/".get_user_ip());
        if($data_info){
            $data = json_decode($data_info,true);
            $country = ($data["location"]["country"]);
            $latin_amearica = [
                "Argentina", "Bolivia", "Brazil", "Chile", "Colombia", "Costa Rica",
                "Cuba", "Dominican Republic", "Ecuador", "El Salvador", "Guatemala",
                "Honduras", "Mexico", "Nicaragua", "Panama", "Paraguay", "Peru",
                "Puerto Rico", "Uruguay", "Venezuela"
            ];
            $this_cookie = in_array($country,$latin_amearica) ? 'es' : 'en';
            setcookie("BAUC_LANGUAGE_COOKIES",$this_cookie,time() + 2592000,"/",$_SERVER['SERVER_NAME']);
            if($this_cookie != $lang){
                header("Location: ".URL.'/'.($this_cookie == 'en' ? 'en/' : ''));
                exit;
            }
        }else{
            setcookie("BAUC_LANGUAGE_COOKIES","es",time() + 86400,"/",$_SERVER['SERVER_NAME']);
        }
    } 
    function get_user_ip() {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
?>