<?php
define("CAPTCHA_KEY", "6LeevwMTAAAAAHvV8RkxkzqtKTibiKFnSiWqeTYF");
require_once "/home/jo5120/db_conn.php";

/**
 *
 * @param $input string to clean
 * @return string cleaned string
 *
 * This function is used to clean input of html tags
 */
function cleanInput($input) {
    return strip_tags(trim($input));
}

/**
 * @param $class_name class to load
 *
 * This function is used to automatically load classes as they are needed
 */
function __autoload($class_name) {
    include 'models/'.$class_name . '.class.php';
}

/**
 * @param mysqli $mysqli
 * @param $name product name
 * @param $description product description
 * @param $price product normal sale price
 * @param $quantity product quantity
 * @param $image path to the image of the product
 * @param $onSale discount price of the product
 *
 * This function inserts a product to the data base
 */
function insertProduct(mysqli $mysqli,$name,$description,$price,$quantity,$image,$onSale) {

    $stmt_query = "INSERT INTO product
                            SET name=?,
                            description=?,
                            price=?,
                            quantity=?,
                            image=?,
                            on_sale=?";

    if ($stmt = $mysqli->prepare($stmt_query)) {
        $stmt->bind_param("ssdisd", $name, $description, $price, $quantity, $image, $onSale);
        $stmt->execute();
        $stmt->store_result();
        $stmt->close();
    }

}

/**
 * @param mysqli $mysqli
 * @param $password
 * @return bool
 *
 * This function validates the admin password against the db
 */
function validateAdminPassword(mysqli $mysqli, $password) {

    $query_string = "SELECT password FROM user WHERE name = 'admin'";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->execute();
        $adminPassword = "";
        $select_stmt->bind_result($adminPassword);
        $select_stmt->fetch();
        $select_stmt->close();

        if($adminPassword == $password) {
            startSession();
            $_SESSION["Admin"] = true;

            setAdminSession($mysqli, session_id());

            return true;
        }
        else {
            return false;
        }
    }

    return false;
}

function setAdminSession(mysqli $mysqli, $sessionId) {
    removeAdminSession($mysqli, $sessionId);
    $stmt_query = "INSERT INTO current_sessions
                                SET
                                session_id=?,
                                admin=TRUE";

    if ($stmt = $mysqli->prepare($stmt_query)) {
        $stmt->bind_param("s", $sessionId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->close();
    }

}

function removeAdminSession(mysqli $mysqli, $sessionId) {

    $query = "DELETE FROM current_sessions WHERE admin = TRUE AND session_id = ?";

    if ($select_stmt = $mysqli->prepare($query)) {

        $select_stmt->bind_param("s", $sessionId);
        $select_stmt->execute();

        $select_stmt->close();
    }
}

function isAdmin(mysqli $mysqli) {

    startSession();
    $sessionId = session_id();
    $query_string = "SELECT admin FROM current_sessions WHERE session_id = ?";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->bind_param("s", $sessionId );
        $select_stmt->execute();
        $select_stmt->bind_result($isAdmin);
        $select_stmt->fetch();

        $select_stmt->close();

        return $isAdmin == 1 ? true : false;
    }

    return false;
}

function validateCaptcha($captcha) {
    $response = json_decode(
                    file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . CAPTCHA_KEY  .
                        "&response=" . $captcha )
    );

    if(isset($response->success) && $response->success == true) {
        return true;
    }
    return false;
}

/**
 * This function uses php functionality to start the session for the user.
 */
function startSession() {
    session_set_cookie_params(0, '/~jo5120/756/project1', 'rit.edu', 0, 1);
    session_name('jGuitarsSessionID');
    session_start();
}

/**
 * @param mysqli $mysqli
 * @return array list of Products
 *
 * Gets all products from the db where the discount price is greater than zero.
 */
function getOnSaleProducts(mysqli $mysqli) {
    $products = array();

    $query_string = "SELECT * FROM product WHERE on_sale > 0";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->execute();
        $select_stmt->bind_result($id, $name, $description, $price, $quantity,
            $image, $onSalePrice);

        while($select_stmt->fetch()) {
            $products[] = new Product($id, $name, $description, $price, $quantity, $image,
                $onSalePrice);
        }

        $select_stmt->close();
    }

    return $products;
}

/**
 * @param mysqli $mysqli
 * @return array list of ids
 *
 * Gets the ids of products from the db where the discount price is greater than zero.
 */
function getOnSaleProductsIds(mysqli $mysqli) {
    $products = getOnSaleProducts($mysqli);
    $ids = array();

    foreach($products as $product) {
        $ids[] = $product->getId();
    }

    return $ids;
}

/**
 * @param mysqli $mysqli data base connector
 * @return array list of products
 *
 * Gets all products in the data base
 */
function getAllProducts(mysqli $mysqli) {
    $products = array();

    $query_string = "SELECT * FROM product";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->execute();
        $select_stmt->bind_result($id, $name, $description, $price, $quantity,
            $image, $onSalePrice);

        while($select_stmt->fetch()) {
            $products[] = new Product($id, $name, $description, $price, $quantity, $image,
                $onSalePrice);
        }

        $select_stmt->close();
    }

    return $products;
}

/**
 * @param mysqli $mysqli data base connector
 * @param $currentPage
 * @param $pageSize
 * @return array list of products for the requested page
 *
 * Returns the products from the db in the given offset, used for paging
 */
function getProductsForPage(mysqli $mysqli,$currentPage, $pageSize) {
    $products = array();

    $query_string = "SELECT * FROM product ORDER BY id LIMIT ?,?";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $offset = $currentPage == 0 ? 0 : ($currentPage - 1) * $pageSize;

        $select_stmt->bind_param("ii", $offset, $pageSize);

        $select_stmt->execute();


        $select_stmt->bind_result($id, $name, $description, $price, $quantity,
            $image, $onSalePrice);

        while($select_stmt->fetch()) {
            $products[] = new Product($id, $name, $description, $price, $quantity, $image,
                $onSalePrice);
        }
        $select_stmt->close();
    }

    return $products;
}

/**
 * @param mysqli $mysqli data base connector
 * @param $id
 * @return null|Product
 *
 * This function gets a product form the db by id
 */
function getProduct(mysqli $mysqli, $id) {

    $query_string = "SELECT * FROM product WHERE id=?";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->bind_param("i",$id);
        $select_stmt->execute();
        $select_stmt->bind_result($id, $name, $description, $price, $quantity,
            $image, $onSalePrice);
        $select_stmt->fetch();

        $product = new Product($id, $name, $description, $price, $quantity, $image,
            $onSalePrice);

        $select_stmt->close();

        return $product;
    }

return null;

}

/**
 * @param mysqli $mysqli db connector
 * @param Product $product
 *
 * This function updates a Product in the db
 */
function saveProduct(mysqli $mysqli, Product $product) {

    $query_string = "UPDATE product SET
                                        name=?,
                                        description=?,
                                        price=?,
                                        quantity=?,
                                        image=?,
                                        on_sale=? WHERE id=?";

    if ($stmt = $mysqli->prepare($query_string)) {
        $stmt->bind_param("ssdisdi", $product->getName(), $product->getDescription(), $product->getPrice(),
                                        $product->getQuantity(), $product->getImage(), $product->getOnSalePrice(),
                                        $product->getId());
        $stmt->execute();
        $stmt->close();
    }

}

/**
 * @param $mysqli
 * @param $productId
 * @param $userSessionId
 *
 * This function adds a product to the cart table, associating it with a user's session
 */
function addProductToCart($mysqli, $productId, $userSessionId) {

    $product = getProduct($mysqli,$productId);

    if($product->getQuantity() > 0) {

        $product->setQuantity( $product->getQuantity() - 1 );

        saveProduct($mysqli, $product);

        $stmt_query = "INSERT INTO cart
                                SET user_session=?,
                                product_id=?,
                                quantity=?";

        if ($stmt = $mysqli->prepare($stmt_query)) {
            $quantity = 1;
            $stmt->bind_param("sii", $userSessionId, $product->getId(), $quantity);
            $stmt->execute();
            $stmt->store_result();
            $stmt->close();
        }
    }
}

/**
 * @param mysqli $mysqli
 * @param $session_id
 * @return array list of products
 *
 * Gets all the products associated with a user's session id in the db
 */
function getUserCart(mysqli $mysqli, $session_id) {

    $cart = array();

    $query_string = "SELECT product.id, product.name, product.description, product.price, product.on_sale,
                              cart.quantity
                        FROM cart JOIN product ON cart.product_id = product.id WHERE cart.user_session =?";

    if ($select_stmt = $mysqli->prepare($query_string)) {
        $select_stmt->bind_param("s", $session_id);
        $select_stmt->execute();

        $select_stmt->bind_result($id, $name, $description, $price, $onSalePrice, $quantity);

        while($select_stmt->fetch()) {

            $cart[] = array(
                "product_id" => $id,
                "product_name" => $name,
                "product_description" => $description,
                "product_price" => $price,
                "product_on_sale" => $onSalePrice,
                "product_quantity" => $quantity,
            );
        }

        $select_stmt->close();
    }

    return $cart;
}

/**
 * @param mysqli $mysqli
 * @param $session_id
 * @return array list of ids
 *
 * Gets all the ids of products associated with a user's session id in the db
 */
function getCartProductsIds(mysqli $mysqli, $session_id) {

    $ids = array();

    $query_string = "SELECT product.id FROM cart JOIN product ON cart.product_id = product.id
                        WHERE cart.user_session =?";

    if ($select_stmt = $mysqli->prepare($query_string)) {

        $select_stmt->bind_param("s", $session_id);
        $select_stmt->execute();

        $select_stmt->bind_result($productId);

        while($select_stmt->fetch()) {
            $ids[] = $productId;
        }

        $select_stmt->close();
    }

    return $ids;
}

/**
 * @param mysqli $mysqli
 * @param $session_id
 *
 * Deletes all records of products in the cart table associated with the session id
 */
function emptyCart(mysqli $mysqli, $session_id) {

    $productIds = getCartProductsIds($mysqli, $session_id);

    foreach($productIds as $id) {
        $product = getProduct($mysqli, $id);
        $product->setQuantity( $product->getQuantity() + 1 );

        saveProduct($mysqli, $product);
    }

    $query = "DELETE FROM cart WHERE user_session = ?";

    if ($select_stmt = $mysqli->prepare($query)) {

        $select_stmt->bind_param("s", $session_id);
        $select_stmt->execute();

        $select_stmt->close();
    }
}

/**
 * @param mysqli $mysqli
 * @return int count of all products
 *
 * Returns the count of all products in the catalog
 */
function getCatalogSize(mysqli $mysqli) {
    $query = "SELECT COUNT(id) FROM product";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count;
    }

    return 0;
}