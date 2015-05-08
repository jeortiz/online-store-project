<div id="header">
    <div id="presentation">
        <div id="logo">
            <img src="images/logo.png" alt="jGuitars logo" height="75" width="75">
        </div>
        <div id="header_title">
            <h1>jGuitars</h1>
        </div>
    </div>
    <div id="navigation">
        <ul class="tabs">
            <?php
                $tabs = array('Home' => 'index.php', 'Cart' => 'cart.php', 'Admin' => 'admin.php');
                foreach($tabs as $key => $value) {
                    $class = $key == $activeTab ? 'active' : '';
                    echo "
                            <li class='{$class}'>
                                <a href='{$value}'>{$key}</a>
                            </li>";
                }
            ?>
        </ul>
    </div>
</div>