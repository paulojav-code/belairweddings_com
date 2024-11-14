export async function request_api({url,json}){
    let req = await fetch(url,{
        method:"POST",
        headers: {"Content-type": "application/json;"},
        body: JSON.stringify(json)
    });
    let res = await req.text();
    let data = JSON.parse(res);

    if(url != URL_API_LOGIN && typeof data.login !== 'undefined' && data.login === false){
        alert_msg({
            msg:'sesion expirada'
        });
        location.reload();
    }

    return data;
}
