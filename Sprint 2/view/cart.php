<?php
/**
 * This php file is designed to manage all operation regarding cart's management
 * Author   : pascal.benzonana@cpnv.ch
 * Project  : Code
 * Created  : 23.03.2019 - 21:40
 *
 * Last update :    [24.03.2019 PBA]
 *                  []
 * Source       :   pascal.benzonana
 */



$title = 'Rent A Snow - Demande de location';

ob_start();
?>
    <h2>Votre panier</h2>
    <article>
        <form method="POST" action="index.php?action=displaySnows">
            <?php
                if(isset($_SESSION['LocationErrors']))
                {
                    echo "La quantité demandée est supérieure au stock !";
                    unset($_SESSION['LocationErrors']);
                }
            ?>

            <table class="table">
                <tr>
                    <th>Code</th><th>Date</th><th>Nombre de jours</th><th>Quantité</th><th>Retirer</th>
                </tr>
                <?php
                    // Displays cart session's content
                    if(isset($_SESSION['cart']))
                    {
                        $cartArray = $_SESSION['cart'];
                        foreach ($cartArray as $article){
                            echo "<tr>";
                            echo "<td>".$article['code']."</td>";
                            echo "<td>".$article['dateD']."</td>";
                            echo "<form method='POST' action='index.php?action=updateCartItem'>";
                            echo "<td><input type='number' name='uNbD' value='".$article['nbD']."' disabled></td>";
                            echo "<td><input type='number' name='uQty' value='".$article['qty']."' disabled></td>";

                            echo "<td><a href='index.php?action=updateCartRequest&code=".$article['code']."'><img src='view/content/images/delete2.png'></a></td>";
                            echo "</form></tr>";
                        }

                    }
                ?>
            </table>
            <table>
                <tr>
                    <td>
                        <input type="submit" value="Louer encore" class="btn btn-success" name="backToCatalog">
                    </td>
                    <td>
                        <input type="submit" value="Vider le panier" class="btn btn-cancel" name="resetCart">
                    </td>
            <form method="POST" action="index.php?action=endLocation">
                    <td>
                        <a href="index.php?action=endLocation"><input type="submit" value="Finaliser la location" class="btn btn-info"  name="locationEnd"></a>
                    </td>
                </tr>
            </form>
            </table>
        </form>
    </article>
<?php
$content = ob_get_clean();
require 'gabarit.php';
?>