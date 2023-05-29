//PER fetch

const num=6;

const barra_di_ricerca=document.getElementById("search_bar");

function onjson(json)
{
    if(!json)
    {
        console.log('C ERRORE:');

        console.log('errore');
    }
    else{
        console.log('DB:');
       console.log(json);
    }
}

function onResponse(response) {
    console.log('Risposta ricevuta');
    console.log(response);
    return response.json();
}

function Preferiti(event){
    const item=event.currentTarget.parentNode.parentNode.parentNode;
    const item_2=event.currentTarget.parentNode;
    const elem= item_2.querySelector('h3');
    const elem_text=encodeURIComponent(elem.textContent);
    const img_no_like =item_2.querySelector('img');
    const img_url=encodeURIComponent(img_no_like.src);

    let type;
    let i;

    if(item.id==='container_album') {
        i = 'album';
        type = encodeURIComponent(i);

        fetch('insert.php?title=' + elem_text + '&immagine=' + img_url + '&type=' + type).then(onResponse).then(onjson);
        console.log('SPEDISCO?');
        event.currentTarget.remove();
        img_like.remove();


    }
    if(item.id==='container_Tracks') {
        t = 'track';
        type = encodeURIComponent(t);

        fetch('insert.php?title=' + elem_text + '&immagine=' + img_url + '&type=' + type).then(onResponse).then(onjson);
        event.currentTarget.remove();
        img_like.remove();


    }
    if(item.id==='Container_Artists') {
        j = 'artist';
        type = encodeURIComponent(j);

        fetch('insert.php?title=' + elem_text + '&immagine=' + img_url + '&type=' + type).then(onResponse).then(onjson);
        event.currentTarget.remove();
        img_like.remove();


    }
}


function jsonAlbum(json){
    if(!json)
    {
        console.log('errore');
    }else{
        console.log(json);
        const doc=document.querySelector("#container_album .here");
        doc.innerHTML='';
        for(let i=0;i<num;i++)
        {
            const container=document.createElement("div");
            const img_like=document.createElement("img");

            const img_album=document.createElement("img");
            img_album.src=json.albums.items[i].images[0].url;
            container.appendChild(img_album);

            const txt=document.createElement("h3");
            txt.textContent=json.albums.items[i].name;
            container.appendChild(txt);
            img_like.classList.add('Like');
            img_like.src='./images/like.png';
            container.appendChild(img_like);
            img_like.addEventListener('click',Preferiti);
            doc.appendChild(container);
        }
    }
}

function jsonTrack(json){

    if(!json)
    {
        console.log('errore-traccia');
    }else{
        console.log(json);
        const doc=document.querySelector("#container_Tracks .here");
        doc.innerHTML='';
        for(let i=0;i<num;i++)
        {
            const container=document.createElement("div");
            const img_like=document.createElement("img");

            const img_track=document.createElement("img");
            img_track.src=json.tracks.items[i].album.images[0].url;
            container.appendChild(img_track);

            const txt=document.createElement("h3");
            txt.textContent=json.tracks.items[i].name;
            container.appendChild(txt);
            img_like.classList.add('Like');
            img_like.src='./images/like.png';
            container.appendChild(img_like);
            img_like.addEventListener('click',Preferiti);
            doc.appendChild(container);
        }
    }
}

function jsonArtist(json){

    if(!json)
    {
        console.log('errore-artista');
    }else{
        console.log(json);
        const doc=document.querySelector("#container_Artists .here");
        doc.innerHTML='';
        for(let i=0;i<num;i++)
        {
            const container=document.createElement("div"); //CREO UN DIV

            const img_artist=document.createElement("img"); //CREO IMG PER ARTISTA
            img_artist.src=json.artists.items[i].images[1].url; //CERCO ARTISTA
            container.appendChild(img_artist); //APPENDO ARTISTA

            const txt=document.createElement("h3"); //CREO TESTO PER ARTISTA
            txt.textContent=json.artists.items[i].name; //TESTO PER ARTISTA
            container.appendChild(txt); //APPENDO TESTO
            
            const img_like=document.createElement("img"); //CREO IMG PER LIKE
            img_like.classList.add('Like'); // AGGIUNGO LIKE
            container.appendChild(img_like); //APPENDO LIKE

            img_like.src='./images/like.png'; //CERCO LIKE
           
            img_like.addEventListener('click',Preferiti); //EVENT
            doc.appendChild(container); //APPENDO
        }
    }
}



//Per ricerca dei contenuti con api spotify
function ricerca(event){
    //ottengo cosa sto scrivendo
    const elemento=event.currentTarget.value;
    const txt=encodeURIComponent(elemento);
    const containers= document.querySelectorAll('#container_album,#container_Tracks,#Container_Artists');

    fetch("ricerca_contenuti.php?q="+txt+'&type=album').then(onResponse).then(jsonAlbum);
    fetch("ricerca_contenuti.php?q="+txt+'&type=track').then(onResponse).then(jsonTrack);
    fetch("ricerca_contenuti.php?q="+txt+'&type=artist').then(onResponse).then(jsonArtist);

    if(elemento==='')
    {
        for (el of containers){
            el.classList.add('hidden');
        }
    }else {
        for (el of containers) {
            el.classList.remove('hidden');
        }

    }
}

if(barra_di_ricerca===null){
    console.log('Vuoto');
}
else{
    barra_di_ricerca.addEventListener('keyup', ricerca);
}
