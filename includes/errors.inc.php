<div id="errors">
    <?php
    if(!empty($errors)) {
        echo '<p>Please fix the following errors:</p>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
    ?>
</div>