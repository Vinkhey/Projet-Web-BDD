<?php
/**
 * This php file is designed to manage all operation regarding cart's management
 * Author   : Romain Onrubia
 * Project  : Code
 * Created  : 20.05.2019 - 09:30
 *
 * Last update :
 */



$title = 'Rent A Snow - Gestion des locations';

ob_start();
?>
    <h2>Gestion des retours</h2>
    <table>
        <tr>
            <td>Location: </td>
            <td>Email: </td>
        </tr>
        <tr>
            <td>Prise: </td>
            <td>Retour: </td>
        </tr>
        <tr>
            <td>Statut: </td>
        </tr>
    </table>
    <article>
        <form method="POST" action="index.php?action=displayCart">
            <table class="table" border="1px">
                <tr>
                    <th>Code</th><th>Quantité</th><th>Retour</th><th>Statut</th>
                </tr>
                <?php
                /** Partie du code encore non fonctionnelle */
                /*$cartArray = $_SESSION['location'];
                foreach ($cartArray as $article){
                echo "<td>".$article['code']."</td>";
                echo "<td>".$article['Quantité']."</td>";
                echo "<td>".$article['dateFin']."</td>";*/
                //echo "<td><select name='Statut' size='1'><option>Rendu<option>En cours</select></td>"
                ?>
            </table>
        </form>
        <table>
            <tr>
                <td>
                    <a href="index.php?action=managementLocation"> <input type="submit" value="Vue d'ensemble" class="btn btn-success" name="vueDEnsemble"></a>
                    <input type="button" value="Enregistrer" class="btn btn-success" name="Save">
                </td>
            </tr>
        </table>
    </article>
<?php
$content = ob_get_clean();
require 'gabarit.php';
?>