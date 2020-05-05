<?php
include ('bd.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Monitoring by Gauss K</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Monitoring by Gauss K</h1>

        <?php
        $ligne = 1; // Compteur de ligne
        $fic = fopen("C:\Users\Gauss\Documents\siteFile_Subrack1.csv", "a+");

        $dateUpdate;
        $bdd->exec('DELETE FROM power');

        while ($tab = fgetcsv($fic, 1024, ";")) {
            $champs = count($tab); // Nombre de champ dans la ligne
            // echo '<b> Les ' . $champs . ' champs de la ligne ' . $ligne . ' sont : </b> <br/>';

            $ligne++;

            $nomSite;
            $ac;
            $dc;

            // Affichage
            for ($i = 0; $i < $champs; $i ++) {
                if ($i == 0 or ! isset($tab[$i])) {
                    $nomSite = $tab[$i];
                } else if ($i == 1 or ! isset($tab[$i])) {
                    $ac = $tab[$i];
                } else if ($i == 2 or ! isset($tab[$i])) {
                    $dc = $tab[$i];
                }
                // echo $tab[$i].'<br/>';
            }

            if (isset($nomSite) AND $nomSite != NULL) {
                // On insert les contenus dans la table 
                $reponse = $bdd->prepare('INSERT INTO power (site, ac, dc, date) VALUES (?, ?, ?, NOW())');
                $reponse->execute(array(trim($nomSite), $ac, $dc));
                // echo $nomSite . ' ' . $ac . ' ' . $dc . '<br/>';
            }
        }
        ?>


        <table class="table">
            <thead>
                <tr>
                    <th>Num</th>
                    <th>Name Site</th>
                    <th>AC (V)</th>
                    <th>DC (V)</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Num</th>
                    <th>Name Site</th>
                    <th>AC (V)</th>
                    <th>DC (V)</th>
                </tr>
            </tfoot>

            <tbody>
                <?php
                $reponse = $bdd->query('SELECT * FROM power ORDER BY ac, dc');
                $nombre = 1;
                while ($donnees = $reponse->fetch()) {
                    $forAC = $donnees['ac'];
                    $forDC = $donnees['dc'];
                    if($donnees['ac'] == 0 AND $donnees['dc'] == 0){
                       
                    } else{
                    ?>

                <tr  style="<?php echo $result = ($donnees['ac'] == 0) ? 'background-color: red' : 'background-color: white'?>">
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $donnees['site']; ?></td>
                        <td><?php echo $donnees['ac']; ?></td>
                        <td><?php echo $donnees['dc']; ?></td>
                        <?php $dateUpdate = $donnees['date']; ?>
                    </tr>

                    <?php
                    $nombre++;
                    }
                }
                $reponse->closeCursor(); // Termine le traitement de la requête
                ?>
            </tbody>
        </table>
        <h3 style="text-align: center">  <?php echo 'Date et heure update '.$dateUpdate; ?> </h3>
    </body>
</html>
