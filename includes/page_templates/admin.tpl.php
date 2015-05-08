<div id="content">
    <?php include_once("includes/errors.inc.php"); ?>
    <div id="add-container">
        <?php
        $submit = "Add Product";
        $submitName = "submit-add-product";
        $suffix = "";
        include("includes/product_form.inc.php");
        ?>
    </div>

    <div id="edit-container">
        <div class="product-form">
            <form method="post" action="admin.php">
                <select name="product-to-edit">
                    <?php
                    foreach($catalog as $product) {
                        if(is_a($product,"Product")) {
                            echo "
                                    <option value='{$product->getId()}'>
                                        {$product->getName()}
                                    </option>
                                ";
                        }
                    }
                    ?>
                </select>
                <input type="submit" name="edit-product" value="Edit" />
            </form>
        </div>
        <?php
        if($productToEdit != null) {

            $name        = $productToEdit->getName();
            $description = $productToEdit->getDescription();
            $price       = $productToEdit->getPrice();
            $quantity    = $productToEdit->getQuantity();
            $onSale      = $productToEdit->getOnSalePrice();
            $image       = $productToEdit->getImage();

            $submit = "Submit Changes";
            $submitName = "submit-edit-product";
            $suffix = "edit";
            include("includes/product_form.inc.php");
        }
        ?>
    </div>
</div>