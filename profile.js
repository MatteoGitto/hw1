function onResponse(response) {
    console.log('Risposta ricevuta');
    return response.json();
}

function  jsonSpotify(json) {

    let random= Math.floor(Math.random()*60); 

    if(!json)
    {
        console.log('errore');
    }
    else{
        console.log(json);
        for (let i=0;i<risultati_canzoni;i++) {
            const integration = document.querySelectorAll('#Discovery  div iframe');
            integration[i].src = "https://open.spotify.com" + '/embed' + '/track/' + json.tracks.items[random+i].track.id;
        }
        loading.style.display = "none"; // Nascondi l'immagine di caricamento una volta che i contenuti sono pronti

    }            

}

const risultati_canzoni=6; 
var loading = document.querySelector("#Discovery .loading img");

loading.style.display = "block"; // Mostra l'immagine di caricamento all'avvio

fetch("spotify.php?type=artist").then(onResponse).then(jsonSpotify);