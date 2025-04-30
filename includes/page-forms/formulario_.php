<?php
    $modal_form_id = 'modal-form-dw';
?>
<div id="<?= $modal_form_id ?>" class="ts-modal">
    <div class="modal-background"></div>
    <div class="modal-content">
        <header>
            <h3><?= $datos_json['contacto_titulo'] ?></h3>
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </header>
        <article>
            <label for=""><?= $datos_json['contacto_nombre'] ?></label>
            <input type="text" id="ts-form-e-name">
        </article>
        <article>
            <label for=""><?= $datos_json['contacto_apellido'] ?></label>
            <input type="text" id="ts-form-e-last_name">
        </article>
        <article>
            <label for=""><?= $datos_json['contacto_correo'] ?></label>
            <input type="text" id="ts-form-e-email">
        </article>
        <article>
            <label for=""><?= $datos_json['contacto_telefono'] ?></label>
            <input type="text" id="ts-form-e-phone">
        </article>
        <article class="full">
            <label for=""><?= $datos_json['contacto_mensaje'] ?></label>
            <textarea id="ts-form-e-message" cols="30" rows="4"></textarea>
        </article>
        <footer>
            <div id="ts-form-e-captcha"></div>
            <button id="ts-form-e-send"><?= $datos_json['contacto_enviar'] ?></button>
        </footer>
    </div>
</div>

<script defer>
    let modalForm = document.querySelector(`#<?= $modal_form_id ?>`);
    let sourceForm = ``;
    let copiesEmail = ``;
    let formLang = `<?= $idioma ?>`;
    let settingPage = false;
    modalForm.querySelector(`.modal-background`).addEventListener('click',function(){closeForm({})});
    modalForm.querySelector(`.close`).addEventListener('click',function(){closeForm({});});

    function openForm({title,source,move,copies}){
        if(title){modalForm.querySelector(`header h3`).innerHTML = title;}
        if(source){sourceForm = source;}
        if(copies){copiesEmail = copies;}
        if(move){settingPage = move}

        if(settingPage){
            settings.keyboardShortcuts.enabled = false;
		    settings.scrollWheel.enabled = false;
        }
        let c = {
            sitekey:'be240d90-e718-4480-abbc-e71e600ecdd6',
            theme: 'dark'
        }
        if(window.innerWidth <= 480){
            c.size = 'compact'
        }

        hcaptcha.render('ts-form-e-captcha',c);
        hcaptcha.reset();

        modalForm.classList.add('active');
    }

    function closeForm(){
        if(settingPage){
            settings.keyboardShortcuts.enabled = true;
		    settings.scrollWheel.enabled = true;
        }
        modalForm.classList.remove('active');
    }

    //enviar    
    document.querySelector(`#ts-form-e-send`).addEventListener('click',async function(){
        let alert_list = {
            'es':{
                '01':'Por favor, completa el CAPTCHA antes de enviar el formulario.',
                '02':'Gracias por contactarnos. Hemos recibido tu mensaje y nos pondremos en contacto contigo lo antes posible.',
                '03':'Lo sentimos, no pudimos enviar tu mensaje. Por favor, inténtalo nuevamente más tarde o contáctanos directamente a través de otro medio.'
            },
            'en':{
                '01':'Please complete the CAPTCHA before submitting the form.',
                '02':'Thank you for contacting us. We have received your message and will get back to you as soon as possible.',
                '03':'We\'re sorry, but we couldn\'t send your message. Please try again later or contact us directly through another channel.'
            }
        }

        let captcha = hcaptcha.getResponse();
        if(!captcha){
            alert(alert_list[formLang]['01']);
        }else{
            let j = {
                domain: `belairweddings.com`,
                captcha: captcha,
                source: sourceForm,
                message: document.querySelector(`#ts-form-e-message`).value
            }
            document.querySelectorAll(`.modal-content article input`).forEach(i=>{
                let a = i.id.split('-')[3];
                if(a){j[a] = i.value;}
            });
            j.copies = `gerencia@eze-trip.com,gerencia@dreams-wedding.com.mx,bodasygrupos@convention-meetings.com,info@belairweddings.com,dreams-wedding.com.mx,mktmanager@dreams-wedding.com.mx,mktmanagerbts@gmail.com,ingresosmanager@coleccionbelair.com`;

            closeForm({});

            let req = await fetch(`https://itrip.mx/services/api/sendmail/`,{
                method:"POST",
                headers: {"Content-type": "application/json;"},
                body: JSON.stringify(j)
            });
            let res = await req.text();
            let data = JSON.parse(res);

            if(data.send){
                alert(alert_list[formLang]['02']);
            }else{
                alert(alert_list[formLang]['03']);
            }
        }
    });
</script>
<style>
    .ts-modal{
        display:none;position:fixed;z-index:20000;width:100%;height:100%;overflow:auto;flex-direction:column;flex-wrap:wrap;justify-content:center;align-items:center;top:0;left:0;padding:0.5em;
        &.active{display:flex;}
        & .modal-background{position:absolute;left:0;top:0;width:100%;height:100%;background-color:rgba(0, 0, 0, 0.3);}
        & .modal-content{
            position: relative;
            z-index:200002;
            background-color:#d0abb1;
            width:40em;
            max-width:100%;
            padding:2em 2em 1em;
            border-radius:1em;
            display:flex;
            flex-direction:row;
            flex-wrap:wrap;
            & header{
                display:flex;
                flex-direction:row;
                padding-bottom:1em;
                align-items:center;
                width:100%;
                & h3{
                    font-size:1.5em;
                    margin:0;
                    width:calc(100% - 2rem);
                    line-height:1em;
                    height:1em;
                }
                & .close{
                    font-size:1em;
                    width:2.5rem;
                    color:#fff;
                    background:transparent;
                    padding:0;
                    border:0;
                    box-shadow:none;
                    text-align:center;
                    cursor:pointer;
                    height:2.5rem;
                    line-height:1em;
                }
            }
            & footer{
                display:flex;
                flex-direction:row;
                flex-wrap:wrap;
                justify-content:flex-end;
                align-items:flex-end;
                padding-top:1em;
                width:100%;
                & button{margin:0 0 1em 1em;}
            }
            & article{
                width:50%;padding:0 0.5em;
                &.full{width:100%;}
                & label{line-height:1.5em;}
            }
            @media screen and (max-width: 480px){
                padding:1.5em 1em 1em;
                & article{
                    padding:0;
                    width:100%;
                }
            }
        }
    }
</style>