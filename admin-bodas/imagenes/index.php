<?php
    include_once('../include/config.php');
	include_once('../include/conexion.php');
	include_once('../include/php/functions.php');

    $title = 'Inicio - Subir Imagenes | BelairWedding';

	include_once('../include/page-forms/header.php');

    $sql='SELECT id_novie, person_1, person_2, conector FROM novies WHERE fecha > CURDATE() ORDER BY id_novie DESC';
    $select_data=query($con,$sql);
?>

<?php include_once('../include/page-forms/navbar.php'); ?>
<!-- css de la pagina -->
<link rel="stylesheet" href="../assets/css/drop_zone.css">
<!-- js de la pagina -->
<!-- <script defer src="../assets/js/drop_zone.js"></script> -->


<div id="page-wrapper"><main>
    <div class="input_container"><p>Ingresa el ID de la boda</p>
        <select name="" id="id_boda">
        <?php foreach ($select_data as $s) {
            $data_novies = $s["id_novie"]." ".$s["person_1"].' '.$s["conector"].' '.$s["person_2"];
            echo'<option value="'.$s["id_novie"].'">'.$data_novies.'</option>';
        }?>
        </select>
    </div>
    <!-- <article id="drop_zone">
        <h3 class="archivos_text">Arrastre los archivos a esta zona <label class="archivos_text" for="files">o haga clic AQUÍ para seleccionar</label></h3>
    </article> -->
    <input type="file" id="files" name="archivos" multiple>
    <div class="div_button"><button id="send">Enviar</button></div>
</main></div>

<?php include_once('../include/page-forms/footer.php'); ?>
<?php include_once('../include/page-forms/scripts.php'); ?>

<script>
    document.querySelector(`#send`).addEventListener('click',async function(){
        let url = '../apis/imagenes/';
        let f = document.querySelector(`#files`).files;
        let i = document.querySelector(`#id_boda`).value;
        let formData = new FormData();

        Object.keys(f).forEach(e => {
            formData.append("files[]", f[e]);
        });

        let req = await fetch(`${url}`,{
            method: "POST", 
            body: formData
        });
        formData.append("id", i);
        let res = await req.text();
        let json = JSON.parse(res);
        if(json.file){
            alert(`Se subieron los archivos: ${JSON.stringify(json.file)}`)
        }else{
            alert(`Error al cargar: `);
            console.log(res);
        }
        // console.log(res);
    });

    async function request_file({url,file,token,id}){
        let formData = new FormData();

        formData.append("file", file);
        formData.append("action", 'files');
        formData.append("token", token);
        formData.append("page", id);

        let req = await fetch(`${url}`,{
            method: "POST", 
            body: formData
        });
        let res = await req.text();
        let json = JSON.parse(res);

        if(typeof json.login !== 'undefined' && json.login === false){
            alert_msg({
                msg:'sesion expirada'
            });
            location.reload();
        }
        
        return json;
    }
</script>