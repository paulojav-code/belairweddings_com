<?php
    $pdfs = scandir("pdfs");
    foreach ($pdfs as $p) {
        if($p == "." || $p == "..") continue;
        $newname = strtolower($p);
        $newname = str_replace(" ","_",$newname);
        rename("./pdfs/".$p,"./pdfs/".$newname);
        $url = "belairuniquecdmx_com/docs/2025/".$newname;
        echo stripslashes($url);
        echo '<br>';
    }
?>