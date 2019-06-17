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
                    <th>Location</th><th>Email du client</th><th>Prise</th><th>Retour</th><th>Statut</th>
                </tr>
                <?php
                /*if(isset($_SESSION['CartErrors']))
                {
                    echo "Erreur sur la quantité demandée";
                    echo "<br>".$_SESSION['CartErrors']."</br>";
                    unset($_SESSION['CartErrors']);
                }
                 Displays cart session's content
                $cartArray = $_SESSION['cart'];
                foreach ($cartArray as $article){

                }*/
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