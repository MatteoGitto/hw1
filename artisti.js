function onResponse(response) {
    console.log('Risposta ricevuta');
    return response.json();
}

function jsonartisti(json){

    if(!json)
    {
        console.log('errore');
    }else{
        console.log(json);
        const doc=document.querySelector(".here");
        doc.innerHTML='';
        for(let i=0;i<9;i++)
        {
            const container_padre=document.createElement("div");

            const img=document.createElement("img");
            img.src=json[i].img;
            container_padre.appendChild(img);
            const txt=document.createElement("h3");
            txt.textContent=json[i].nome;
            container_padre.appendChild(txt);
            const desc=document.createElement('p');
            desc.textContent=json[i].descrizione;
            container_padre.appendChild(desc);
            doc.appendChild(container_padre);
        }
    }
}


fetch("fetch_db_artista.php").then(onResponse).then(jsonartisti);
