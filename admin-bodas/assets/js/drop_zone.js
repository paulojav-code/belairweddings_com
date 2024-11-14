const file = document.querySelector("#files");
const drop_zone = document.querySelector("#drop_zone");
const send_button = document.querySelector('#send');
const id_boda = document.querySelector('#id_boda');
let a = "";
let url="../apis/imagenes/"
let array_files=[];

drop_zone.addEventListener('dragover', e => {
    e.preventDefault();
    drop_zone.style.borderColor = '#e44c65';
});

drop_zone.addEventListener('dragleave', e => {
    e.preventDefault();
    drop_zone.style.borderColor = '#fff'; 
});
document.addEventListener('drop', e => {
    e.preventDefault();
});
document.addEventListener('dragover', e => {
    e.preventDefault();
});

drop_zone.addEventListener('drop', subir_archivo);
file.addEventListener('change', subir_archivo);

send_button.addEventListener('click', () => send({url:url,file:a,id:id_boda.value}))

function subir_archivo(e) {
    let file_img = "";
    e.preventDefault();
    
    e.target.id == "files" ? a = file.files : a = e.dataTransfer.files;
    
    if (a.length > 0) {
        Object.keys(a).forEach(i=> {
            let reader = new FileReader();
            array_files.push(a[i]);
            reader.onload = event => {
                let img_src = event.target.result;
                file_img += `<div id="drop"><img class="file_img" src="${img_src}" alt=""><h4>${a[i].name}</h4></div>`;
                
                // Actualiza el contenido del drop_zone cada vez que se carga una imagen 
                drop_zone.innerHTML = file_img;
            };
            reader.readAsDataURL(a[i]);
        });
    }
};

async function send({url,file,id}){
    if(id == "" || file == ""){
        alert("Faltan datos")
    }else{
        let formData = new FormData();
        array_files.forEach(f => {
            // console.log(f.name, f.size, f.type);
            formData.append('files[]',f)
        });
        formData.append('id',id_boda.value)
        let req = await fetch(`${url}`,{
            method: "POST", 
            body: formData
        });
        
        let res = await req.text();
        // let json = JSON.parse(res);
        console.log(res)
        // if(json.file){
        //     exito();
        // }
    }
    
}

// async function send({url,file,token,id}){
//     if(id == "" || file == ""){
//         alert("Faltan datos")
//     }
//     else{
//         let formData = new FormData();
//         formData.append("file", file);
//         formData.append("action", 'files');
//         formData.append("id", id);
//         let req = await fetch(`${url}`,{
//             method: "POST", 
//             body: formData
//         });
//         let res = await req.text();
//         let json = JSON.parse(res);
//         console.log(json)
//         return json;
//     }
    
// }

function exito (j) {
    alert("Las imagenes se subieron corrctamente");
    location.reload();
}