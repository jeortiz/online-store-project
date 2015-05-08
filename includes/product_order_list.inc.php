<table>
    <thead>
    <tr>
        <th></th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalPrice = 0;
    foreach($products as $key => $orderItem) {
        $orderPrice = $orderItem['product_on_sale'] > 0 ? $orderItem['product_on_sale'] : $orderItem['product_price'];
        $totalPrice += $orderPrice;
        echo "
            <tr>
                <td>
                    <h5>{$orderItem['product_name']}</h5>
                    <p>{$orderItem['product_description']}</p>
                </td>
                <td style='text-align: right'>
                    {$orderItem['product_quantity']}
                </td>
                <td style='text-align: right'>
                    \${$orderPrice}
                </td>
            </tr>
        ";
    }

    ?>
    </tbody>
    <tfoot>
    <tr>
        <th id="total" colspan="2">Total :</th>
        <td>$<?=$totalPrice?></td>
    </tr>
    </tfoot>
</table>