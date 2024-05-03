<?php
function dd() {
    // Récupérer tous les arguments passés à la fonction
    $args = func_get_args();

    // Récupérer les informations sur l'endroit où la fonction a été appelée
    $backtrace = debug_backtrace();
    $file = $backtrace[0]['file'];
    $line = $backtrace[0]['line'];

    echo '<pre style="background:black;color:white;padding:1rem;">';
    echo "<strong>Debug called in file $file on line $line:</strong><br>";
    foreach ($args as $arg) {
        if (is_array($arg)) {
            $arg = print_r($arg, true);
        
            // Colorer en vert les clés de tableau
            $arg = preg_replace_callback('/\[(.*)\] =>/', function ($matches) {
                return '[<span style="color: greenyellow;">' . $matches[1] . '</span>] =>';
            }, $arg);
            // Colorer en rouge les valeurs
            $arg = preg_replace_callback('/=> (.*)/', function ($matches) {
                // var_dump($matches);
                $type = gettype($matches[1]);
                return '=> <span style="color: red;">' . $matches[1] . '</span> </span> <span style="color: blue;">' . $type . '</span>';
            }, $arg);

        }else {
            $type = gettype($arg);
            $arg = '<span style="color: greenyellow;">' . var_export($arg, true) . '</span> <span style="color: blue;">' . $type . '</span>';
        }
        echo $arg;
    }
    echo '</pre>';
    die();
}


function dd1() {
    $args = func_get_args();

    $backtrace = debug_backtrace();
    $file = $backtrace[0]['file'];
    $line = $backtrace[0]['line'];

    echo '<pre style="background:black;color:white;padding:1rem;">';
    echo "<strong>Debug called in file $file on line $line:</strong><br>";
    foreach ($args as $arg) {
        if (is_array($arg)) {
            foreach ($arg as $key => $value) {
                echo '<span style="color: green;">' . $key . '</span> => ';
                if (is_array($value)) {
                    print_r($value);
                } else {
                    echo '<span style="color: white;">' . $value . '</span>';
                }
                echo '<br>';
            }
        } else {
            echo $arg;
        }
    }
    echo '</pre>';
    die();
}


