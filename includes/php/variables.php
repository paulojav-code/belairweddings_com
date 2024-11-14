<?php
    function format_phone($number){
        return sprintf("%s %s %s",substr($number, 0, 3),substr($number, 3, 3),substr($number, 6));
    }
    
    $phone_number = '3341700489';
    $whatsapp_url = 'https://api.whatsapp.com/send?phone=3319902132&text=Hola,%20me%20gustar%C3%ADa%20reservar%20la%20Boda%20de%20mis%20sue%C3%B1os';
    $email = 'info@dreams-wedding.com.mx';
    $facebook_url = ' https://www.facebook.com/belairdreamswedding';
    $instagram_url = 'https://www.instagram.com/belairdreamswedding';
?>