import express from "express";
import fs from "fs"; //treballar amb arxius
import bodyParser from "body-parser"; //Ho afegim per entendre que estem rebent un json des de la petició post.

//Creo l'objecte de l'aplicació
const app=express();
app.use(bodyParser.json())

//Funció per llegir la informació
const readData=()=>{
    try{
        const data=fs.readFileSync("./db.json");
        //console.log(data);
        //console.log(JSON.parse(data));
        return JSON.parse(data)

    }catch(error){
        console.log(error);
    }
};

//Funció per escriure informació
const writeData=(data)=>{
    try{
        fs.writeFileSync("./db.json",JSON.stringify(data));

    }catch(error){
        console.log(error);
    }
}

app.get("/",(req,res)=>{
    res.send("Welcome to my first API with Node.js");
});

//Creem un endpoint per obtenir tots els articles
app.get("/articulos",(req,res)=>{
    const data=readData();
    res.json(data.articulos);
});

//Creem un endpoint per obtenir un article per un id
app.get("/articulos/:id",(req,res)=>{
    const data=readData();
    //Extraiem l'id de l'url recordem que req es un objecte tipus requets
    // que conté l'atribut params i el podem consultar
    const id=parseInt(req.params.id);
    const article=data.articulos.find((article)=>article.id===id);
    res.json(article);
})

//Creem un endpoint del tipus post per afegir un article
app.post("/articulos",(req,res)=>{
    const data=readData();
    const body=req.body;
    //todo lo que viene en ...body se agrega al nuevo articulo
    const newArticle={
        id:data.articulos.length+1,
        ...body,
    };
    data.articulos.push(newArticle);
    writeData(data);
    res.json(newArticle);
});

//Creem un endpoint per modificar un article
app.put("/articulos/:id", (req, res) => {
    const data = readData();
    const body = req.body;
    const id = parseInt(req.params.id);
    const articleIndex = data.articulos.findIndex((article) => article.id === id);
    data.articulos[articleIndex] = {
      ...data.articulos[articleIndex],
      ...body,
    };
    writeData(data);
    res.json({ message: "Article updated successfully" });
});

//Creem un endpoint per eliminar un article
app.delete("/articulos/:id", (req, res) => {
    const data = readData();
    const id = parseInt(req.params.id);
    const articleIndex = data.articulos.findIndex((article) => article.id === id);
    //splice esborra a partir de articleIndex, el número de elements 
    // que li indiqui al segon argument, en aquest cas 1
    data.articulos.splice(articleIndex, 1);
    writeData(data);
    res.json({ message: "Article deleted successfully" });
});

//Funció per escoltar
app.listen(3000,()=>{
    console.log("Server listing on port 3000");
});