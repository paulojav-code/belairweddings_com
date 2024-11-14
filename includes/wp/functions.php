<?php
    const SERVER_URL = 'http://localhost/web/dreams-wedding_com_mx/';
    const WP_URL = 'wpp/';
    const URL = SERVER_URL.WP_URL;

    function query($con,$sql,$params = []){
        $stmt = $con->prepare($sql);
        if($params != []){
            call_user_func_array([$stmt,'bind_param'],$params);
        }
        try{
            $stmt->execute();
            
            $res = [];
            $result = $stmt->get_result();
            if(isset($result->num_rows) && $result->num_rows > 0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $res[] = $row;
                }
            }
            return $res;
        }catch(Throwable $th){
            return ['error'=>$con->error];
        }
    }
    function getWPId($con){
        $id = 0;
        $lang = 0;
        $back = '';
        $flag = [];

        $script = str_replace('index.php','',$_SERVER['SCRIPT_NAME']);
        $route = str_replace($script,'',$_SERVER['REQUEST_URI']);
        $route = explode('/',$route);
        
        $back = str_repeat('../',count($route));

        $sql = "SELECT id_novie, IF(idiomas='en','1:1,2','1:1') AS idiomas FROM admin_bodas.novies WHERE activo = 1 AND (ruta = ? OR id_novie = ?);";
        $res = query($con,$sql,['ss',&$route[0],&$route[0]]);
        if(!$res){
            return [];   
        }
        $id = $res[0]['id_novie'];
        $default_lang = explode(':',$res[0]['idiomas']);
        $default_lang[1] = explode(',',$default_lang[1]);
        $lang = $default_lang[0];

        $route[1] = isset($route[1]) ? $route[1] : '';
        $num_lang_wp = count($default_lang[1]);
        if($num_lang_wp > 1){
            $sql = "SELECT id_idioma, siglas FROM admin_bodas.idiomas WHERE activo = 1;";
            $res = query($con,$sql);
            $list_lang = [];
            foreach($res as $e){
                $list_lang[$e['id_idioma']] = $e['siglas'];
                if($e['siglas'] == $route[1]){
                    $lang = $e['id_idioma'];
                }
            }
            $index_this_lang = array_search($lang,$default_lang[1]);
            $index_next_lang = ($index_this_lang+1)>($num_lang_wp-1)? 0 : $index_this_lang + 1;
            $flag = [$list_lang[$default_lang[1][$index_next_lang]],($lang!=$default_lang[0])?$route[0].'/':$route[0].'/'.$list_lang[$default_lang[1][$index_next_lang]].'/'];
        }

        return [$id,$lang,$back,$flag];
    }
    function getWPData($con,$id,$lang){
        $col = [
            'person_1','person_2','conector'
        ];
        $wp = [];
        $sql = "SELECT ".implode(', ',$col)."
            FROM novies WHERE id_novie = ?;";
        $res = query($con,$sql,['i',&$id]);
        $wp = isset($res[0]) ? $res[0] : [];

        return $wp;
    }
    function getImages($id,$back){
        $img = [];
        $img['cover'] = file_exists('../assets/img/wp/pages/'.$id.'/cover.jpg')? $back.'assets/img/wp/pages/'.$id.'/cover.jpg' : $back.'assets/img/wp/pages/default/cover.jpg';

        return $img;
    }

    function _getWPId($conn){
        $ruta = str_replace(str_replace('index.php','',$_SERVER['SCRIPT_NAME']),'',$_SERVER['REQUEST_URI']);
        $ruta = explode('/',$ruta)[0];

        $id_boda = 0;
        if(!intval($ruta)){
            $stmt = $conn->prepare('SELECT id_novie FROM admin_bodas.novies WHERE ruta LIKE ? AND activo = 1;');
            $stmt->bind_param("s",$ruta);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){while($row = $result->fetch_array(MYSQLI_ASSOC)){$id_boda = $row['id_novie'];}}
        }else{
            $id_boda = $ruta;
        }
        
        return $id_boda;
    }
    // function dateFormat($str_date,$type = 'dd/mm/yyyy') {
    //     $str_date_explode  = explode('-',$str_date);
    
    //     $meses = [
    //         'es' => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    //         'en' => ['January','February','March','April','May','June','July','August','September','October','November','December']
    //     ];
        
    //     switch($type){
    //         case 'dd/mm/yyyy':
    //             $str_date_formater = $str_date_explode[2].'/'.$str_date_explode[1].'/'.$str_date_explode[0];
    //             break;
    //         case 'mm/dd/yyyy':
    //             $str_date_formater = $str_date_explode[1].'/'.$str_date_explode[2].'/'.$str_date_explode[0];
    //             break;
    //         case 'dd M yyyy':
    //             $str_date_formater = $str_date_explode[2].' de '.$meses['es'][intval($str_date_explode[1]) - 1].' '.$str_date_explode[0];
    //             break;
    //         case 'M dd yyyy':
    //             if(intval($str_date_explode[2]) == 1 || intval($str_date_explode[2]) == 21 || intval($str_date_explode[2]) == 31){
    //                 $terminacion = 'st';
    //             }else if(intval($str_date_explode[2]) == 2 || intval($str_date_explode[2]) == 22){
    //                 $terminacion = 'nd';
    //             }else if(intval($str_date_explode[2]) == 3 || intval($str_date_explode[2]) == 23){
    //                 $terminacion = 'rd';
    //             }else{
    //                 $terminacion = 'th';
    //             }
    //             $str_date_formater = $meses['en'][intval($str_date_explode[1]) - 1].' '.intval($str_date_explode[2]).$terminacion.', '.$str_date_explode[0];
    //             break;
    //         default:
    //             break;
    //     }
    
    //     return $str_date_formater;
    // }
    // function phoneFormat($str_num,$type = '33') {
    //     if($str_num!=''){
    //         switch($type){
    //             case '33':
    //                 $str_num[11] = $str_num[9];
    //                 $str_num[10] = $str_num[8];
    //                 $str_num[9]  = $str_num[7];
    //                 $str_num[8]  = $str_num[6];
    //                 $str_num[7]  = ' ';
    //                 $str_num[6]  = $str_num[5];
    //                 $str_num[5]  = $str_num[4];
    //                 $str_num[4]  = $str_num[3];
    //                 $str_num[3]  = $str_num[2];
    //                 $str_num[2]  = ' ';
    //                 break;
    //             case '800':
    //                 $str_num[11] = $str_num[9];
    //                 $str_num[10] = $str_num[8];
    //                 $str_num[9]  = $str_num[7];
    //                 $str_num[8]  = $str_num[6];
    //                 $str_num[7]  = ' ';
    //                 $str_num[6]  = $str_num[5];
    //                 $str_num[5]  = $str_num[4];
    //                 $str_num[4]  = $str_num[3];
    //                 $str_num[3]  = ' ';
    //                 break;
    //             default:
    //                 break;
    //         }
    //         return $str_num;
    //     }else{
    //         return $str_num;
    //     }
    // }
    // function timeFormat($str_time,$type = 'am/pm') {
    //     $str_time_explode = explode(':',$str_time);
    
    //     switch($type) {
    //         case 'am/pm':
    //             if(intval($str_time_explode[0]) < 12) {
    //                 $str_time_formater = $str_time_explode[0].':'.$str_time_explode[1].' a.m.';
    //             }else if(intval($str_time_explode[0]) > 12){
    //                 $str_time_formater = (intval($str_time_explode[0]) - 12).':'.$str_time_explode[1].' p.m.';
    //             }else {
    //                 $str_time_formater = $str_time_explode[0].':'.$str_time_explode[1].' p.m.';
    //             }
    //             break;
    //         default:
    //             break;
    //     }
    
    //     return $str_time_formater;
    // }
    // function getSplitDateTime($date,$type = 'date') {
    //     $datetime_split = explode(' ',$date);
    
    //     switch($type) {
    //         case 'date': 
    //             $datetime_split = $datetime_split[0];
    //             break;
    //         case 'time':
    //             $datetime_split = $datetime_split[1];
    //             break;
    //         default:
    //             break;
    //     }
    
    //     return $datetime_split;
    // }
    function _getWPData($conn,$id,$lang){
        $wp = [];

        $sql = 'SELECT * FROM admin_bodas.data_novie WHERE activo = 1 AND id_idioma = ? AND id_novie = ?;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$lang,$id);
        if(!$stmt->execute()){
            return [];
        }else{
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){$wp = $row;}
            }else{
                return [];
            }
        }

        $wp['gifts'] = [];
        $sql = 'SELECT titulo, descripcion, enlace FROM admin_bodas.mesa_regalos WHERE activo = 1 AND id_idioma = ? AND id_novie = ?;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$lang,$id);
        if(!$stmt->execute()){
            return [];
        }else{
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){$wp['gifts'][] = $row;}
            }
        }

        $wp['ceremonies'] = [];
        $sql = 'SELECT * FROM admin_bodas.data_ceremonia WHERE activo = 1 AND id_idioma = ? AND id_novie = ?;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$lang,$id);
        if(!$stmt->execute()){
            return [];
        }else{
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){$wp['ceremonies'][] = $row;}
            }
        }

        $wp['rooms'] = [];
        $sql = 'SELECT * FROM admin_bodas.data_habitacion WHERE activo = 1 AND id_idioma = ? AND id_novie = ?;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii",$lang,$id);
        if(!$stmt->execute()){
            return [];
        }else{
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){$wp['rooms'][] = $row;}
            }
        }

        $wp['comments'] = [];
        $sql = 'SELECT * FROM admin_bodas.comentarios WHERE activo = 1 AND id_novie = ?;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        if(!$stmt->execute()){
            return [];
        }else{
            $result = $stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){$wp['comments'][] = $row;}
            }
        }

        return $wp;
    }
?>