import express from "express";
import fs from "fs"; //treballar amb arxius
import bodyParser from "body-parser"; //Ho afegim per entendre que estem rebent un json des de la petició post.
import cors from "cors";

//Creo l'objecte de l'aplicació
const app = express();

app.use(cors());
app.use(bodyParser.json())

//Funció per llegir la informació
const readData = () => {
    try {
        const data = fs.readFileSync("./db.json");
        //console.log(data);
        //console.log(JSON.parse(data));
        return JSON.parse(data)

    } catch (error) {
        console.log(error);
    }
};

//Funció per escriure informació
const writeData = (data) => {
    try {
        fs.writeFileSync("./db.json", JSON.stringify(data));

    } catch (error) {
        console.log(error);
    }
};

// Ruta arrel
app.get("/", (req, res) => {
    res.send("Benvingut a l'API del Daily Bugle");
});

// ENDPOINTS

// ARTICLES

// GET tots els articles
app.get("/articulos", (req, res) => {
    const data = readData();
    res.json(data.articulos);
});

// GET un article per id
app.get("/articulos/:id", (req, res) => {
    const data = readData();
    // Extraiem l'id de l'url recordem que req es un objecte tipus requets
    // que conté l'atribut params i el podem consultar
    const id = parseInt(req.params.id);
    const article = data.articulos.find((article) => article.id === id);
    if (!article) return res.status(404).json({ message: "Article no trobat"});
    res.json(article);
});

// POST crear article
app.post("/articulos", (req, res) => {
    const data = readData();
    const body = req.body;
    const maxId = data.articulos.reduce((max, a) => Math.max(max, a.id), 0);
    //tot el que ve a...body s'afegeix al nou article
    const newArticle = {
        id: maxId + 1,
        ...body,
        vistas: 0
    };
    data.articulos.push(newArticle);
    writeData(data);
    res.status(201).json(newArticle);
});

// PUT modificar article
app.put("/articulos/:id", (req, res) => {
    const data = readData();
    const body = req.body;
    const id = parseInt(req.params.id);
    const articleIndex = data.articulos.findIndex((article) => article.id === id);
    if(index === -1) return res.status(404).json({ message: "Article no trobat" });
    data.articulos[articleIndex] = {
        ...data.articulos[articleIndex],
        ...body,
    };
    writeData(data);
    res.json({ message: "Article actualitzat correctament" });
});

// PATCH incrementar vistas de un articulo
app.patch("/articulos/:id", (req, res) => {
    const data = readData();
    const id = parseInt(req.params.id);

    const articulo = data.articulos.find((a) => a.id === id);

    if (!articulo) {
        return res.status(404).json({ message: "Article no trobat" });
    }

    // incrementar vistas
    articulo.vistas = (articulo.vistas || 0) + 1;

    writeData(data);

    res.json({
        message: "Vista incrementada",
        vistas: articulo.vistas
    });
});

// DELETE eliminar article
app.delete("/articulos/:id", (req, res) => {
    const data = readData();
    const id = parseInt(req.params.id);
    const articleIndex = data.articulos.findIndex((article) => article.id === id);
    if (articleIndex === -1) return res.status(404).json({ message: "Article no trobat" });
    // splice esborra a partir de articleIndex, el número de elements 
    // que li indiqui al segon argument, en aquest cas 1
    data.articulos.splice(articleIndex, 1);
    writeData(data);
    res.json({ message: "Article eliminat correctament" });
});

// AUTORS

// GET tots els autors
app.get("/autores", (req, res) => {
    const data = readData();
    res.json(data.autores);
});

// CATEGORIES

// GET totes les categories
app.get("/categorias", (req, res) => {
    const data = readData();
    res.json(data.categorias);
});

// TIPS (Contacte)

// GET tots els tips
app.get("/tips", (req, res) => {
    const data = readData();
    res.json(data.tips);
});

// POST enviar un tip
app.post("/tips", (req, res) => {
    const data = readData();
    const body = req.body;
    const maxId = data.tips.reduce((max, t) => Math.max(max, t.id), 0);
    const newTip = {
        id: maxId + 1,
        ...body,
        fecha: new Date().toISOString().split("T")[0]
    };
    data.tips.push(newTip);
    writeData(data);
    res.status(201).json(newTip);
});

//Funció per escoltar
app.listen(3000, () => {
    console.log("Servidor escoltant al port 3000");
});