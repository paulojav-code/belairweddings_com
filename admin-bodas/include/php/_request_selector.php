<?php
    if(isset($_POST['request']) || isset($_GET['request'])){
        if(isset($_POST['request'])) {
            $_POST['request'] = urldecode($_POST['request']);
            $a_rec = json_decode($_POST['request'], true);
        }else if(isset($_GET['request'])) {
            $_GET['request'] = urldecode($_GET['request']);
            $a_rec = json_decode($_GET['request'], true);
        }
    }else{
        echo '{"error": "Request Parametros faltantes"}';
        exit;
    }
    function listarArchivos( $path ){
        $dir_list = array();
        $dir = opendir($path);
        while ($elemento = readdir($dir)){
            if( $elemento != "." && $elemento != ".."){
                if( is_dir($path.$elemento) ){
                    $dir_list[] = $elemento;
                    //listarArchivos($path.$elemento.'/');
                } else {
                    //echo '<div class="col-4 col-6-narrower"><img src="'.$path.$elemento.'" alt="" class="image fit"></div>';
                }
            }
        }
        return $dir_list;
    }
    function list_dir( $path ){
        $dir_list = array();
        $dir = opendir($path);
        while ($elemento = readdir($dir)){
            if( $elemento != "." && $elemento != ".."){
                if( is_dir($path.$elemento) ){
                    $dir_list[] = $elemento;
                }
            }
        }
        return $dir_list;
    }
    function list_file( $path ){
        $dir_list = array();
        $dir = opendir($path);
        while ($elemento = readdir($dir)){
            if( $elemento != "." && $elemento != ".."){
                if( !is_dir($path.$elemento) ){
                    $dir_list[] = $elemento;
                }
            }
        }
        return $dir_list;
    }
    function create_source($name, $type) {
        if (preg_match('/jpg|jpeg|JPG|JPEG/', $type)) { $data = imagecreatefromjpeg($name); }
        if (preg_match('/png/', $type)) { $data = imagecreatefrompng($name); }
        if (preg_match('/gif/', $type)) { $data = imagecreatefromgif($name); }
        return $data;
    }
    function set_imagesize($img) {
        $img_sizes = getimagesize($img[0]);
        $img[] = $img_sizes[0];
        $img[] = $img_sizes[1];
        return $img;
    }
    function save_image($source, $type, $new_name) {
        if (preg_match('/jpg|jpeg|JPG|JPEG/',$type)) { imagejpeg($source, $new_name); }
        if (preg_match('/png/', $type)) { imagepng($source, $new_name); }
        if (preg_match('/gif/', $type)) { imagegif($source, $new_name); }
    }
    function resize_image($original_image_data, $original_width, $original_height, $new_width, $new_height) {
        $dst_img = ImageCreateTrueColor($new_width, $new_height);
        imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0));
        imagecopyresampled($dst_img, $original_image_data, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        return $dst_img;
    }
    function crope_image($original_image_data, $original_width, $original_height, $new_width, $new_height, $i_ox, $i_oy) {
        if(($new_height/$new_width) < ($original_height/$original_width)){
            $m_width = $original_width;
            $m_height = ($original_width*$new_height)/$new_width;
            //$type_oy = [0, ($original_height - $m_height) * .25, ($original_height - $m_height) * .5, ($original_height - $m_height) * .75, ($original_height - $m_height)];
            $ox = 0;
            $oy = ($original_height - $m_height) * ($i_oy/100);
            echo $i_oy;
            echo ' ';
        }else{
            $m_height = $original_height;
            $m_width = ($original_height*$new_width)/$new_height;
            //$type_ox = [0, ($original_width - $m_width) * .25, ($original_width - $m_width) * .43, ($original_width - $m_width) * .75, ($original_width - $m_width)];
            $ox = ($original_width - $m_width) * ($i_ox/100);
            $oy = 0;
            echo $i_ox;
            echo ' ';
        }
        $dst_img = ImageCreateTrueColor($new_width, $new_height);
        imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0));
        imagecopyresampled($dst_img, $original_image_data, 0, 0, $ox, $oy, $new_width, $new_height, $m_width, $m_height);
        return $dst_img;
    }
    function form_image($dir,$form) {
        $img = explode('.',$form['url']);
        $img[0] = '../../assets/img/wp/'.$form['url'];
        orientation_image($img[0],$img[1]);
        $img = set_imagesize($img);
        $img[4] = '../../assets/img/wp/'.$dir.'/img/0.jpg';
        $img[5] = '../../assets/img/wp/'.$dir.'/img/form.jpg';
        $img_source = create_source($img[0],$img[1]);
        if($img[2] <= 1920 && $img[3] <= 1920){
            copy($img[0],$img[4]);
        }else{
            if($img[2] > $img[3]){
                $img_resize = resize_image($img_source,$img[2],$img[3],1920,round(($img[3]*1920)/$img[2]));
            }else{
                $img_resize = resize_image($img_source,$img[2],$img[3],round(($img[2]*1920)/$img[3]),1920);
            }
            save_image($img_resize,$img[1],$img[4]);
        }
        if($img[2] > $img[3] && $img[3] < 800){
            $img_crope = crope_image($img_source,$img[2],$img[3],$img[3],$img[3],$form['size'][0],$form['size'][1]);
        }else if ($img[2] < 800) {
            $img_crope = crope_image($img_source,$img[2],$img[3],$img[2],$img[2],$form['size'][0],$form['size'][1]);
        }else{
            $img_crope = crope_image($img_source,$img[2],$img[3],800,800,$form['size'][0],$form['size'][1]);
        }
        save_image($img_crope,$img[1],$img[5]);
    }
    function cover_image($dir,$cover) {
        $img = explode('.',$cover['url']);
        $img[0] = '../../assets/img/wp/'.$cover['url'];
        orientation_image($img[0],$img[1]);
        $img = set_imagesize($img);
        $img[4] = '../../assets/img/wp/'.$dir.'/img/cover.jpg';
        $img[5] = '../../assets/img/wp/'.$dir.'/img/mini-small.jpg';
        $img[6] = '../../assets/img/wp/'.$dir.'/img/mini-large.jpg';
        $img_source = create_source($img[0],$img[1]);
        $img_crope = crope_image($img_source,$img[2],$img[3],1920,1080,$cover['size']['cover'][0],$cover['size']['cover'][1]);
        save_image($img_crope,$img[1],$img[4]);
        $img_crope = crope_image($img_source,$img[2],$img[3],450,450,$cover['size']['small'][0],$cover['size']['small'][1]);
        save_image($img_crope,$img[1],$img[5]);
        $img_crope = crope_image($img_source,$img[2],$img[3],450,900,$cover['size']['large'][0],$cover['size']['large'][1]);
        save_image($img_crope,$img[1],$img[6]);
    }
    function galeria_image($dir,$galeria) {
        for ($i=0; $i < count($galeria); $i++) { 
            $img = explode('.',$galeria[$i]['url']);
            $img[0] = '../../assets/img/wp/'.$dir.'/'.$galeria[$i]['url'];
            orientation_image($img[0],$img[1]);
            $img = set_imagesize($img);
            $img[4] = '../../assets/img/wp/'.$dir.'/img/'.($i+1).'.jpg';
            $img[5] = '../../assets/img/wp/'.$dir.'/img/'.($i+1).'-m.jpg';
            $img_source = create_source($img[0],$img[1]);
            if($img[2] <= 1920 && $img[3] <= 1920){
                copy($img[0],$img[4]);
            }else{
                if($img[2] > $img[3]){
                    $img_resize = resize_image($img_source,$img[2],$img[3],1920,round(($img[3]*1920)/$img[2]));
                }else{
                    $img_resize = resize_image($img_source,$img[2],$img[3],round(($img[2]*1920)/$img[3]),1920);
                }
                save_image($img_resize,$img[1],$img[4]);
            }
            $img_crope = crope_image($img_source,$img[2],$img[3],600,400,$galeria[$i]['size'][0],$galeria[$i]['size'][1]);
            save_image($img_crope,$img[1],$img[5]);
        }
    }
    function orientation_image($d,$t){
        $exif = exif_read_data($d);
        if ($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if ($orientation != 1) {
                $img = create_source($d, $t);
                $deg = 0;
                switch ($orientation) {
                    case 3:
                        $deg = 180;
                        break;
                    case 6:
                        $deg = 270;
                        break;
                    case 8:
                        $deg = 90;
                        break;
                }
                if ($deg) {
                    $img = imagerotate($img, $deg, 0);
                }
                save_image($img, $t, $d);
                // imagejpeg($img, $d, 95);
            }
        }
    }
    
    $a_res = array();
    if(isset($a_rec['id'])){
        switch($a_rec['id']){
            case '0':
                $a_res = list_dir("../../assets/img/wp/");
                break;
            case '1':
                $a_res = list_file("../../assets/img/wp/".$a_rec['dir']."/");
                break;
            case '2':
                if(!file_exists('../../assets/img/wp/'.$a_rec['dir'].'/img/')){
                    mkdir('../../assets/img/wp/'.$a_rec['dir'].'/img/', 0700);
                }
                form_image($a_rec['dir'],$a_rec['form']);
                cover_image($a_rec['dir'],$a_rec['cover']);
                break;
            case '3':
                if(!file_exists('../../assets/img/wp/'.$a_rec['dir'].'/img/')){
                    mkdir('../../assets/img/wp/'.$a_rec['dir'].'/img/', 0700);
                }
                galeria_image($a_rec['dir'],$a_rec['galeria']);
                break;
            default:
                echo '{"error": "Invalid ID"}';
                exit;
        }
    }else{
        echo '{"error": "ID faltantes"}';
        var_dump($_POST['request']);
        exit;
    }
    echo json_encode($a_res);
?>