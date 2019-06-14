<?php
/**
 * This php file is designed to manage all operation regarding cart's management
 * Author   : Romain Onrubia
 * Project  : Code
 * Created  : 20.05.2019 - 09:30
 *
 * Last update :
 */



$title = 'Rent A Snow - Location effectuée';

ob_start();
?>
    <h2>Votre panier</h2>
    <article>
        <form method="POST" action="index.php?action=displayCart">
            <table class="table">
                <tr>
                    <th>N° Location</th><th>Code</th><th>Marque</th><th>Modèle</th><th>Prix</th><th>Quantité</th><th>Date début de location</th>
                </tr>
                <?php
                // Displays cart session's content
                $cartArray = $_SESSION['location'];
                foreach ($cartArray as $article){
                    echo "<td>".$article['idLocations']."</td>";
                    echo "<td>".$article['code']."</td>";
                    echo "<td>".$article['brand']."</td>";
                    echo "<td>".$article['model']."</td>";
                    echo "<td>".$article['dailyPrice']."</td>";
                    echo "<td>".$article['Quantité']."</td>";
                    echo "<td>".$article['dateDebut']."</td>";
                    echo "<form method='POST' action='index.php?action=updateCartItem'>";
                    //echo "<td><input type='number' name='uQty' value='".$article['Quantité']."' disabled></td>";
                    //echo "<td><input type='number' name='uNbD' value='".$article['dateDebut']."' disabled></td>";
                    echo "</form></tr>";
                }
                ?>
            </table>
        </form>
    </article>
<?php
$content = ob_get_clean();
require 'gabarit.php';
?>