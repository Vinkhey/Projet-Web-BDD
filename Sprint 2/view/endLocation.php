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
                    <th>Code</th><th>Date</th><th>Marque</th><th>Modèle</th><th>Prix</th><th>Nombre de jours</th><th>Quantité</th>
                </tr>
                <?php
                if(isset($_SESSION['CartErrors']))
                {
                    echo "Erreur sur la quantité demandée";
                    echo "<br>".$_SESSION['CartErrors']."</br>";
                    unset($_SESSION['CartErrors']);
                }

                // Displays cart session's content
                $cartArray = $_SESSION['cart'];
                foreach ($cartArray as $article){
                    echo "<td>".$article['code']."</td>";
                    echo "<td>".$article['dateD']."</td>";
                    echo "<td>".$article['brand']."</td>";
                    echo "<td>".$article['model']."</td>";
                    echo "<td>".$article['dailyPrice']."</td>";
                    echo "<form method='POST' action='index.php?action=updateCartItem'>";
                    echo "<td><input type='number' name='uQty' value='".$article['qty']."' disabled></td>";
                    echo "<td><input type='number' name='uNbD' value='".$article['nbD']."' disabled></td>";
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