<?php
session_start();
function filter_1() {
    // Chemin vers le fichier CSS
    $cssFilePath = 'public/mycssstylesheet.css';

    // Ouvre le fichier en lecture
    $fileContent = file_get_contents($cssFilePath);

    // Supprime tous les espaces.
    $fileContent = preg_replace('/\s+/', '', $fileContent);

    // Ajoute un saut de ligne après chaque accolade fermante
    $fileContent = preg_replace('/\}(.*?)\./', '}' . PHP_EOL . '.', $fileContent);

    $fileContent = preg_replace_callback('/\{([^}]*)\}/', function ($matches) {
        // Ajouter un espace après chaque deux-points
        $result = preg_replace('/:(?! )/', ': $1', $matches[1]);
    
        return '{' . $result . '}';
    }, $fileContent);


    file_put_contents("base_css.css",$fileContent);
}

// filter_1();

if (isset($_POST['rGenerateCss'])) {  
    
    $datas = $_POST['rGenerateCss'];
    $baseCssPath = 'base_css.css';
    $baseFileContent = fopen($baseCssPath, 'r+');
    
    $regles_original = explode("}", $css_original);
    $regles_a_ajouter = explode("}", $css_a_ajouter);

    // Http_referer semble fonctionner pour indiquer quel fichier à initié la requête.
    $generatedCssPath = "public" . DIRECTORY_SEPARATOR . "css" .  DIRECTORY_SEPARATOR . basename(
        $_SERVER['HTTP_REFERER'],'.php') . "-generated.css";
    $generatedCssPathV2 = "public" . DIRECTORY_SEPARATOR . "css" .  DIRECTORY_SEPARATOR . 'main' . "-generated-V2.css";

    $generatedCssFile = fopen($generatedCssPath,'w+');
    $tabtemoin = [];
    while ($line = fgets($baseFileContent)) {
        
        foreach ($datas as $data) {
            if (str_starts_with($line,".$data") && !in_array(".$data",$tabtemoin)){
                $tabtemoin[] = ".$data";
                    fwrite($generatedCssFile,$line);
                }
            }
        }
       
    fclose($baseFileContent);
    fclose($generatedCssFile);

    fusionner_css($generatedCssPathV2, $generatedCssPath, $generatedCssPathV2);


}


function fusionner_css($fichier_original, $fichier_a_ajouter, $fichier_sortie) {
    // Lire le contenu des fichiers CSS
    $css_original = file_get_contents($fichier_original);
    $css_a_ajouter = file_get_contents($fichier_a_ajouter);
    
    // Séparer les règles CSS en tableaux
    $regles_original = explode("}", $css_original);
    $regles_a_ajouter = explode("}", $css_a_ajouter);
    
    // Supprimer les espaces et les retours à la ligne en trop
    $regles_original = array_map('trim', $regles_original);
    $regles_a_ajouter = array_map('trim', $regles_a_ajouter);
    
    // Enlever la dernière chaîne vide
    array_pop($regles_original);
    array_pop($regles_a_ajouter);
    
    // Comparer les règles et ajouter celles qui ne sont pas déjà présentes
    $nouvelles_regles = [];
    foreach ($regles_a_ajouter as $regle) {
        if (!in_array($regle, $regles_original)) {
            $nouvelles_regles[] = $regle;
        }
    }
    
    $nouveau_css = implode("}\n", $nouvelles_regles);
    if (!empty($nouveau_css)) {
        $nouveau_css .= "}\n";
    }
    // Écrire le résultat dans le fichier de sortie
    file_put_contents($fichier_sortie, $css_original . $nouveau_css, LOCK_EX);
}


