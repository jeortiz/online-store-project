<h3><?= $title ?></h3>
<hr />
<ul>
    <?php
        foreach($products as $product) {
            $discount = false;
            if(is_a($product,"Product")) {

                if($product->getOnSalePrice() > 0) $discount = true;

                $priceClass = $discount ? "old-price" : '';

                echo '<li>';
                echo    '<div>';
                echo    '<div class="image-container">';
                echo        "<img src='images/{$product->getImage()}' alt='{$product->getName()}' height='100' />";
                echo    '</div>';
                echo        "<div class='description'>";
                echo            "<h5>{$product->getName()}</h5>";
                echo            "<p>{$product->getDescription()}</p>";
                echo            "<p>
                                    <span>Price: </span><span class='{$priceClass}'>\${$product->getPrice()}</span>&nbsp;";
                if($discount) {
                    echo           "<span class='discount_price'>\${$product->getOnSalePrice()}</span>&nbsp;";
                }
                echo               "&nbsp;&nbsp;<span>In stock: {$product->getQuantity()}</span>
                                </p>";
                if($product->getQuantity() > 0) {
                    echo
                                "<form method='post' action='{$addToCartAction}'>
                                    <input type='hidden' name='product-id' value='{$product->getId()}' />
                                    <input type='submit' name='add-product-to-cart' value='Add to cart' />
                                </form>";
                }
                echo        "</div>";
                echo    '</div>';
                echo '</li>';


            }
        }
    ?>
</ul>

<?php include("paging.inc.php") ?>

