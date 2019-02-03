<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 13.01.18
 * Time: 14:21
 *
 * @var $items dench\products\models\Variant[]
 * @var $cart array
 */

echo $this->render('_table', [
    'items' => $items,
    'cart' => $cart,
]);