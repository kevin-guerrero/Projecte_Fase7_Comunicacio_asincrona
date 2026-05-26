<?php 
// Crear la base de dades
$db = new SQLite3('Bugle.db');

$db->exec("
    CREATE TABLE IF NOT EXISTS articulos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titular TEXT NOT NULL,
        subtitular TEXT NOT NULL,
        cuerpo TEXT NOT NULL,
        autor TEXT NOT NULL,
        categoria TEXT NOT NULL,
        fecha TEXT NOT NULL,
        destacado INTEGER NOT NULL,
        vistas INTEGER NOT NULL
    )
");

// Insertar dades
$db->exec("
    INSERT INTO articulos 
    (titular, subtitular, cuerpo, autor, categoria, fecha, destacado, vistas)
    VALUES

    (
        '¡Spider-Man destruye el puente de Brooklyn!',
        'Testigos afirman que el enmascarado provocó el caos deliberadamente',
        'Nuestro director J. Jonah Jameson denuncia que el vigilante conocido como Spider-Man es directamente responsable del caos ocurrido ayer en el puente de Brooklyn.',
        'J. Jonah Jameson',
        'portada',
        '1999-06-23',
        1,
        1443
    ),

    (
        'Spider-Man: ¿héroe o amenaza pública?',
        'El debate que divide a Nueva York',
        'Ciudadanos de todos los barrios de Nueva York expresan opiniones encontradas sobre la figura del vigilante enmascarado.',
        'Betty Brant',
        'opinion',
        '1999-07-01',
        0,
        985
    ),

    (
        'Robado el laboratorio Oscorp: Spider-Man en el lugar de los hechos',
        'La empresa de Norman Osborn sufre el robo de material radiactivo',
        'En la madrugada del martes, el laboratorio principal de Oscorp Industries fue objeto de un robo.',
        'Peter Parker',
        'crimen',
        '1999-07-10',
        0,
        2103
    ),

    (
        'El Ayuntamiento rechaza identificar a vigilantes enmascarados',
        'El concejal de seguridad dice que no es prioritario',
        'La propuesta presentada por el Daily Bugle ante el Ayuntamiento de Nueva York ha sido rechazada.',
        'J. Jonah Jameson',
        'politica',
        '1999-07-15',
        0,
        763
    ),

    (
        'Vecinos de Queens organizan una colecta para Spider-Man',
        'La comunidad agradece al enmascarado haber salvado a tres niños',
        'Vecinos del barrio de Forest Hills han organizado una colecta popular para agradecer a Spider-Man.',
        'Betty Brant',
        'sociedad',
        '1999-07-20',
        0,
        1856
    )
");
?>