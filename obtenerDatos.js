const URL_API = 'http://localhost:3000/articulos';

async function carregarNoticies() {
    try {
        const resposta = await fetch(URL_API);
        const articles = await resposta.json();

        const contenidor = document.getElementById('news-container');
        contenidor.innerHTML = '';

        articles.forEach(art => {
            const noticiaHTML = `
                <article>
                    <h1>${art.titular}</h1>
                    <h2>${art.subtitular}</h3>
                </article>
            `;
            contenidor.innerHTML += noticiaHTML;
        });

    } catch (error) {
        console.error("Error carregant les notícies:", error);
        document.getElementById('news-container').innerHTML = "No s'han pogut carregar les notícies del Daily Bugle.";
    }
}

document.addEventListener('DOMContentLoaded', carregarNoticies);
