<div id="content">
    <div id="order_list">
        <?php
        $title = "On Sale!";
        $products = getUserCart($mysqli, session_id());

        if(count($products) > 0) {
            include("includes/product_order_list.inc.php");
            echo "
                        <form method='post' action='cart.php'>
                            <input type='submit' value='Empty Cart' name='empty_cart' />
                        </form>
                    ";
        }
        else {
            echo '<p>Your cart is empty</p>';
        }
        ?>

    </div>
</div>