<?php
function phoneFormat($str_num,$type = '33') {
    if($str_num!=''){
        switch($type){
            case '33':
                $str_num[11] = $str_num[9];
                $str_num[10] = $str_num[8];
                $str_num[9]  = $str_num[7];
                $str_num[8]  = $str_num[6];
                $str_num[7]  = ' ';
                $str_num[6]  = $str_num[5];
                $str_num[5]  = $str_num[4];
                $str_num[4]  = $str_num[3];
                $str_num[3]  = $str_num[2];
                $str_num[2]  = ' ';
                break;
            case '800':
                $str_num[11] = $str_num[9];
                $str_num[10] = $str_num[8];
                $str_num[9]  = $str_num[7];
                $str_num[8]  = $str_num[6];
                $str_num[7]  = ' ';
                $str_num[6]  = $str_num[5];
                $str_num[5]  = $str_num[4];
                $str_num[4]  = $str_num[3];
                $str_num[3]  = ' ';
                break;
            default:
                break;
        }
        return $str_num;
    }else{
        return $str_num;
    }
}

function dateFormat($str_date,$type = 'dd/mm/yyyy') {
    $str_date_explode  = explode('-',$str_date);

    $meses = [
        'es' => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        'en' => ['January','February','March','April','May','June','July','August','September','October','November','December']
    ];
    
    switch($type){
        case 'dd/mm/yyyy':
            $str_date_formater = $str_date_explode[2].'/'.$str_date_explode[1].'/'.$str_date_explode[0];
            break;
        case 'mm/dd/yyyy':
            $str_date_formater = $str_date_explode[1].'/'.$str_date_explode[2].'/'.$str_date_explode[0];
            break;
        case 'dd M yyyy':
            $str_date_formater = $str_date_explode[2].' de '.$meses['es'][intval($str_date_explode[1]) - 1].' '.$str_date_explode[0];
            break;
        case 'M dd yyyy':
            if(intval($str_date_explode[2]) == 1 || intval($str_date_explode[2]) == 21 || intval($str_date_explode[2]) == 31){
                $terminacion = 'st';
            }else if(intval($str_date_explode[2]) == 2 || intval($str_date_explode[2]) == 22){
                $terminacion = 'nd';
            }else if(intval($str_date_explode[2]) == 3 || intval($str_date_explode[2]) == 23){
                $terminacion = 'rd';
            }else{
                $terminacion = 'th';
            }
            $str_date_formater = $meses['en'][intval($str_date_explode[1]) - 1].' '.intval($str_date_explode[2]).$terminacion.', '.$str_date_explode[0];
            break;
        default:
            break;
    }

    return $str_date_formater;
}

function timeFormat($str_time,$type = 'am/pm') {
    $str_time_explode = explode(':',$str_time);

    switch($type) {
        case 'am/pm':
            if(intval($str_time_explode[0]) < 12) {
                $str_time_formater = $str_time_explode[0].':'.$str_time_explode[1].' a.m.';
            }else if(intval($str_time_explode[0]) > 12){
                $str_time_formater = (intval($str_time_explode[0]) - 12).':'.$str_time_explode[1].' p.m.';
            }else {
                $str_time_formater = $str_time_explode[0].':'.$str_time_explode[1].' p.m.';
            }
            break;
        default:
            break;
    }

    return $str_time_formater;
}

function getSplitDateTime($date,$type = 'date') {
    $datetime_split = explode(' ',$date);

    switch($type) {
        case 'date': 
            $datetime_split = $datetime_split[0];
            break;
        case 'time':
            $datetime_split = $datetime_split[1];
            break;
        default:
            break;
    }

    return $datetime_split;
}
?>