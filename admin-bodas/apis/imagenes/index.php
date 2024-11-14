<?php
include_once("../../include/php/const.php");
    
    $json['files'] = $_FILES['files'];
    $json['id'] = $_POST['id'];

    // $json['name'] = $_POST['names'];
    // echo json_encode($json);
    // foreach ($json['tmp_name'] as $temp) {
    //     var_dump($temp);
    //     echo '<hr />';
    // }
    // echo json_encode($json);
    echo json_encode(create_folder($json));

	function create_folder($d){
        if($_SERVER['SERVER_NAME'] != 'localhost'){
            $url_root = 'C:/inetpub/wwwroot/belairweddings_com/admin-bodas/assets/img/wp/'.$d['id'].'/';
        }else{
            $url_root = '../../assets/img/wp/'.$d['id'].'/';
        }
        
        if(!file_exists($url_root)){
            mkdir($url_root, 0700);
        }
        
        $url = $d['files']['name'];
        foreach ($d['files']['tmp_name'] as $i => $t) {
            // echo $t.' - '.$url_root.$url[$i]."\n";
            move_uploaded_file($t, $url_root.$url[$i]);
        }
    
        if(file_exists($url_root.$url[0])){
            return ['file'=> $url];
        }else{
            return ['error'=>'file no copiado'];
        }
    }
?>
