//verifico la presenza di un preferito
function checkIsFavourite(title,url){

    /*Questa funzione verifica se l'utente ha quel preferito*/
    const favourites = document.querySelectorAll(" #preferiti_albums  .here div,#preferiti_tracks .here div,#preferiti_artists .here div");

    for(like of  favourites){

        if(like.querySelector("h3").textContent === title && (like.querySelector("img").src === url))
        {
            console.log('Copia');
            return true;
        }

    }

    return false;
}

function onjson(json)
{
    if(!json)
    {
        console.log('errore');
    }
    else{
       console.log(json);

    }
}

//rimuove elemento dai preferiti
function remove(event){

    const button_div = event.currentTarget.parentNode;
    const div_h3=button_div.querySelector('h3');
    const title=encodeURIComponent(div_h3.textContent);
    button_div.remove();

    fetch("rimozione_preferiti.php?title="+title).then(onResponse).then(onjson);
}

function artist(json)
{
    if(!checkIsFavourite(json.title,json.img.src)){

        const artists = document.querySelector('#preferiti_artists .here');

        const container = document.createElement("div");

        const img = document.createElement("img");
        img.src = json.img;
        container.appendChild(img);

        const txt = document.createElement("h3");
        txt.textContent = json.title;
        container.appendChild(txt);
        const img_2 = document.createElement("img");
        img_2.src = './images/dislike.png';

        img_2.classList.add('preferiti_');
        img_2.addEventListener('click', remove);
        container.appendChild(img_2);
        artists.appendChild(container);
    }
}

function album(json)
{
    if(!checkIsFavourite(json.title,json.img.src)) {
        const albums = document.querySelector('#preferiti_albums .here');

        const container = document.createElement("div");

        const img = document.createElement("img");
        img.src = json.img;
        container.appendChild(img);

        const txt = document.createElement("h3");
        txt.textContent = json.title;
        container.appendChild(txt);

        const img_2 = document.createElement("img");
        img_2.src = './images/dislike.png';
        img_2.classList.add('preferiti_');
        img_2.addEventListener('click', remove);

        container.appendChild(img_2);
        albums.appendChild(container);
    }
    else{
        console.log('Duplicato');
        return;
    }
}

function tracks(json)
{

    if(!checkIsFavourite(json.title,json.img.src)) {
        const tracks = document.querySelector('#preferiti_tracks .here');

        const container = document.createElement("div");

        const img = document.createElement("img");
        img.src = json.img;
        container.appendChild(img);

        const txt = document.createElement("h3");
        txt.textContent = json.title;
        container.appendChild(txt);

        const img_2 = document.createElement("img");
        img_2.src = './images/dislike.png';
        img_2.classList.add('preferiti_');
        img_2.addEventListener('click', remove);

        container.appendChild(img_2);
        tracks.appendChild(container);
    }
}


function jsonDB(json) {
    if (!json) {
        console.log('errore');
    }
    else {
        console.log(json);

        for (let i = 0; i < json.length; i++) {
            switch (json[i].tipo){
                case 'album':
                {
                    album(json[i]);
                    break;
                }
                case 'track':
                {
                    tracks(json[i]);
                    break
                }
                case 'artist':
                {
                    artist(json[i]);
                    break;
                }
            }

        }
    }

}

fetch('fetch_db_like.php').then(onResponse).then(jsonDB);

/*-----------------------------------------------------------*/
const testo=document.querySelector('#invio');
testo.addEventListener('click', getTesto); //per iframe

//PER fetch
function onResponse(response) {
    console.log('Risposta ricevuta');
    console.log(response);
    return response.json();
}

//jsonApi_url
function jsonApi_url(json)
{
    if(!json)
    {
        console.log('errore');
    }
    else{
        console.log('SPOTIFY:');
        console.log(json);
        const integration= document.querySelector('#lyrics iframe');
        integration.src="https://open.spotify.com"+'/embed'+'/track/'+json.tracks.items[0].id; 
    }
}

//REFRESH
function refresh(event){
    const sec=document.querySelector('#testo');
    sec.innerHTML='';
    const container=document.querySelector('form span');
    container.remove();
    const integration= document.querySelector('#lyrics iframe');
    integration.classList.add('hidden');
    integration.src="";
    event.currentTarget.addEventListener('click',getTesto);
    event.currentTarget.removeEventListener('click',refresh);
}

function getTesto(event){
    const form=document.querySelector('form');

    const titolo=form.titolo.value;
    console.log(titolo);

    const artista=form.artista.value;
    console.log(artista);

    const h2_title=document.createElement('h2');
    h2_title.textContent=titolo;

    const container=document.querySelector('#testo');
    container.appendChild(h2_title);

    fetch("spotify.php?q="+encodeURIComponent(titolo)+'&artist='+encodeURIComponent(artista)+'&type=track').then(onResponse).then(jsonApi_url);

    const integrazione= document.querySelector('#lyrics iframe');
    integrazione.classList.remove('hidden');

    const messaggio=document.createElement('span');
    messaggio.textContent='Fai doppio click sul pulsante per cercare una nuova canzone';

    form.appendChild(messaggio);

    event.currentTarget.addEventListener('click',refresh);
    event.currentTarget.removeEventListener('click',getTesto);

}