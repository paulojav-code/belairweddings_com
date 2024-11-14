<?php
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
        if (preg_match('/jpg|jpeg|JPG/', $type)) { $data = imagecreatefromjpeg($name); }
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
        if (preg_match('/jpg|jpeg|JPG/',$type)) { imagejpeg($source, $new_name); }
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
            $type_oy = [
                0, ($original_height - $m_height) / 2.8, ($original_height - $m_height) / 2, (($original_height - $m_height) / 4) * 3, $original_height - $m_height
            ];
            $ox = 0;
            $oy = $type_oy[$i_oy];
        }else{
            $m_height = $original_height;
            $m_width = ($original_height*$new_width)/$new_height;
            $type_ox = [
                0, ($original_width - $m_width) / 4, ($original_width - $m_width) / 2, (($original_width - $m_width) / 4) * 3, $original_width - $m_width
            ];
            $ox = $type_ox[$i_ox];
            $oy = 0;
        }
        $dst_img = ImageCreateTrueColor($new_width, $new_height);
        imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0));
        imagecopyresampled($dst_img, $original_image_data, 0, 0, $ox, $oy, $new_width, $new_height, $m_width, $m_height);
        return $dst_img;
    }
    /*
    $aux = list_file('../../assets/img/hotel/');
    var_dump($aux);
    foreach($aux as $i){
        $img = explode('.',$i);
        $img[0] = '../../assets/img/hotel/'.$i;
        $img = set_imagesize($img);
        $img[4] = '../../assets/img/hotel/_source/'.$i;
        $img_source = create_source($img[0],$img[1]);
        $img_crope = crope_image($img_source,$img[2],$img[3],600,400,0,0);
        save_image($img_crope,$img[1],$img[4]);
    }*/
    $i = 'grand-park-royal-vallarta-mini-4.jpg';
    $img = explode('.',$i);
    $img[0] = '../../assets/img/hotel/'.$i;
    $img = set_imagesize($img);
    $img[4] = '../../assets/img/hotel/_source/banner_'.$i;
    $img_source = create_source($img[0],$img[1]);
    $img_crope = crope_image($img_source,$img[2],$img[3],1300,370,0,1);
    save_image($img_crope,$img[1],$img[4]);
?>