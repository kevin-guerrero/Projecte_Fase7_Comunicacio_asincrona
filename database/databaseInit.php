<?php 
// Crear la base de dades
$db = new SQLite3('Bugle.db');

// Taula articles
$db->exec("
    CREATE TABLE IF NOT EXISTS articulos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titular TEXT NOT NULL,
        subtitular TEXT NOT NULL,
        cuerpo TEXT NOT NULL,
        autor TEXT NOT NULL,
        categoria TEXT NOT NULL,
        fecha TEXT NOT NULL,
        destacado INTEGER NOT NULL DEFAULT 0,
        vistas INTEGER NOT NULL DEFAULT 0
    )
");

// Taula categories
$db->exec("
    CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL UNIQUE,
        descripcio TEXT NOT NULL DEFAULT ''
    )
");

// Taula usuaris
$db->exec("
    CREATE TABLE IF NOT EXISTS usuaris (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nom TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        contrasenya TEXT NOT NULL,
        rol TEXT NOT NULL DEFAULT 'usuari',
        ubicacio TEXT NOT NULL DEFAULT '',
        telefon TEXT NOT NULL DEFAULT '',
        data_registre TEXT NOT NULL
    )
");

// Dades inicials: articles
$count = $db->querySingle("SELECT COUNT(*) FROM articulos");

if ($count == 0) {
    $db->exec("
        INSERT INTO articulos (titular, subtitular, cuerpo, autor, categoria, fecha, destacado, vistas) VALUES
        (
            '¡Spider-Man destruye el puente de Brooklyn!',
            'Testigos afirman que el enmascarado provocó el caos deliberadamente',
            'Nuestro director J. Jonah Jameson denuncia que el vigilante conocido como Spider-Man es directamente responsable del caos ocurrido ayer en el puente de Brooklyn.',
            'J. Jonah Jameson', 'portada', '1999-06-23', 1, 1443
        ),
        (
            'Spider-Man: ¿héroe o amenaza pública?',
            'El debate que divide a Nueva York',
            'Ciudadanos de todos los barrios de Nueva York expresan opiniones encontradas sobre la figura del vigilante enmascarado.',
            'Betty Brant', 'opinion', '1999-07-01', 0, 985
        ),
        (
            'Robado el laboratorio Oscorp: Spider-Man en el lugar de los hechos',
            'La empresa de Norman Osborn sufre el robo de material radiactivo',
            'En la madrugada del martes, el laboratorio principal de Oscorp Industries fue objeto de un robo.',
            'Peter Parker', 'crimen', '1999-07-10', 0, 2103
        ),
        (
            'El Ayuntamiento rechaza identificar a vigilantes enmascarados',
            'El concejal de seguridad dice que no es prioritario',
            'La propuesta presentada por el Daily Bugle ante el Ayuntamiento de Nueva York ha sido rechazada.',
            'J. Jonah Jameson', 'politica', '1999-07-15', 0, 763
        ),
        (
            'Vecinos de Queens organizan una colecta para Spider-Man',
            'La comunidad agradece al enmascarado haber salvado a tres niños',
            'Vecinos del barrio de Forest Hills han organizado una colecta popular para agradecer a Spider-Man.',
            'Betty Brant', 'sociedad', '1999-07-20', 0, 1856
        )
    ");
}

// Dades inicials: categories
$countCat = $db->querySingle("SELECT COUNT(*) FROM categories");

if ($countCat == 0) {
    $db->exec("
        INSERT INTO categories (nom, descripcio) VALUES
        ('portada', 'Notícies de portada del Daily Bugle'),
        ('opinion', 'Articles d''opinió dels nostres redactors'),
        ('crimen', 'Crims i successos de Nova York'),
        ('politica', 'Política local i nacional'),
        ('sociedad', 'Notícies de societat i comunitat')
    ");
}

// Dades inicials: usuaris
$countUs = $db->querySingle("SELECT COUNT(*) FROM usuaris");

if ($countUs == 0) {
    // admin: contrasenya = admin123 | usuari: contrasenya = password
    $db->exec("
        INSERT INTO usuaris (nom, email, contrasenya, rol, ubicacio, telefon, data_registre) VALUES
        ('JJJameson', 'jjj@dailybugle.com', '" . md5('admin123') . "', 'admin', 'Nova York', '555-0001', '1999-01-01'),
        ('BettyBrant', 'betty@dailybugle.com', '" . md5('password') . "', 'usuari', 'Manhattan', '555-0002', '1999-02-15'),
        ('PeterParker', 'peter@dailybugle.com', '" . md5('password') . "', 'usuari', 'Queens', '555-0003', '1999-03-20')
    ");
}

echo "Base de dades inicialitzada correctament.\n";
$db->close();
?>