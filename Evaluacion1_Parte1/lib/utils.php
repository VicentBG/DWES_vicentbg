<?php

// Funciones que cargan arrays asociativas con los datos que existen en csv
function lista($item) {
    $fichero = "./bbdd/".$item.".csv";
    $datos = array();
    if (($puntero = fopen($fichero, 'r')) !== false) {
        while (($filaDatos = fgetcsv($puntero, 1000, ",")) !== false) {
            $datos[$filaDatos[0]] = array(
                'id' => $filaDatos[0],
                'nombre' => $filaDatos[1],
                'ano' => $filaDatos[2],
                'dato' => $filaDatos[3]
            );
        }
    }
    return $datos;
}

function relacion($item) {
    $fichero = "./bbdd/".$item.".csv";
    $datos = array();
    if (($puntero = fopen($fichero, 'r')) !== false) {
        while (($filaDatos = fgetcsv($puntero, 1000, ",")) !== false) {
            $datos[] = array($filaDatos[0], $filaDatos[1]);
        }
    }
    return $datos;
}

// Función que guarda las modificaciones realizadas a la peli
function editar_pelicula($datos) {
    $pelis = lista('peliculas');
    $pelis[$datos[0]]['nombre'] = $datos[1];
    $pelis[$datos[0]]['ano'] = $datos[2];
    $pelis[$datos[0]]['dato'] = $datos[3];
    guardaPelis($pelis);
}

// Función que borra una peli
function borrar_pelicula($id) {
    $pelis = lista('peliculas');
    foreach ($pelis as $key=>$peli) {
        if ($peli['id'] === $id) {
            unset($pelis[$key]);
        }
    }
    guardaPelis($pelis);
}

// Función para guardar las pelis en bbdd
function guardaPelis($pelis) {
    if (($puntero = fopen("./bbdd/peliculas.csv", 'w')) !== false) {
        foreach ($pelis as $key=>$peli) {
            $arrayFila = $peli;
            fputcsv($puntero, $arrayFila, ",");
        }
    }
}

// Función para recuperar los directores
function getDirectores($id) {
    $relaciones = relacion('pelicula_director');
    $dires = array();
    foreach ($relaciones as $key=>$datos) {
        if ($datos[0] === $id) {
            $dires[] = $datos[1];
        }
    }
    return $dires;
}

// Función para recuperar los actores
function getActores($id) {
    $relaciones = relacion('pelicula_actor');
    $actores = array();
    foreach ($relaciones as $key=>$datos) {
        if ($datos[0] === $id) {
            $actores[] = $datos[1];
        }
    }
    return $actores;
}