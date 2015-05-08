<div id="content">
    <div id="on_sale_products" class="product_list content_item">
        <?php
        $title = "On Sale!";
        $products = getOnSaleProducts($mysqli);
        $totalItems = count($products);
        include("includes/product_list.inc.php");
        ?>
    </div>
    <div id="product_catalog" class="product_list content_item">
        <?php
        $title = "Catalog";
        $products = getProductsForPage($mysqli, $currentPage, $pageSize);
        $totalItems = getCatalogSize($mysqli);
        include("includes/product_list.inc.php");
        ?>
    </div>
</div>