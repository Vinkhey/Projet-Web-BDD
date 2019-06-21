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
<h2>Gestion des locations en cours</h2>
<article>
    <form method="POST" action="index.php?action=displayCart">
        <table class="table" border="1px">
            <tr>
                <th>Location</th><th>Email du client</th><th>Prise</th><th>Retour</th><th>Statut</th>
            </tr>
            <?php
            /*$cartArray = $_SESSION['location'];
            foreach ($cartArray as $article){
            echo "<td>".$article['idLocations']."</td>";
            echo "<td>".$article['eMail']."</td>";
            echo "<td>".$article['dateDebut']."</td>";
            echo "<td>".$article['']."</td>";*/
            echo "<td><select name='Statut' size='1'><option>Rendu<option>En cours</select></td>"
            ?>
        </table>
    </form>
    <table>
        <tr>
            <td>
                <a href="index.php?action=managementReturn"><input type="submit" value="Finaliser" class="btn btn-info"  name="Finalisation"></a>
            </td>
        </tr>
    </table>
</article>
<?php
$content = ob_get_clean();
require 'gabarit.php';
?>
