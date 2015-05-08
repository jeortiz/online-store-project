<div class="product-form">
    <form method="post" action="admin.php">

        <?php

        if($productToEdit != null) {
            echo "<input type='hidden' value='{$productToEdit->getId()}' name='product-id' />";
        }
        ?>

        <label for="product-name<?=$suffix?>">Name:</label><br />
        <input type="text" name="product-name" id="product-name<?=$suffix?>" value="<?= $name ?>"/><br/>

        <label for="product-description<?=$suffix?>">Description:</label><br />
        <textarea name="product-description" id="product-description<?=$suffix?>" cols="50" rows="3"><?= $description ?></textarea><br/>

        <label for="product-price<?=$suffix?>">Price:</label><br />
        <input type="text" name="product-price" id="product-price<?=$suffix?>" value="<?= $price ?>"/><br/>

        <label for="product-quantity<?=$suffix?>">Quantity on hand:</label><br />
        <input type="text" name="product-quantity" id="product-quantity<?=$suffix?>" value="<?= $quantity ?>"/><br/>

        <label for="product-sale-price<?=$suffix?>">Sale Price:</label><br />
        <input type="text" name="product-sale-price" id="product-sale-price<?=$suffix?>" value="<?= $onSale ?>"/><br/>

        <label for="product-image<?=$suffix?>">New Image:</label><br />
        <input type="text" name="product-image" id="product-image<?=$suffix?>" value="<?= $image ?>"/><br/>

        <input type="submit" name="<?= $submitName ?>" value="<?= $submit ?>" />

    </form>
</div>