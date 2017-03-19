<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 12.03.17
 * Time: 15:45
 */

namespace app\widgets;

class NavBar extends \yii\bootstrap\NavBar
{
    public $headerHtml = '';

    protected function renderToggleButton()
    {
        return parent::renderToggleButton() . $this->headerHtml;
    }
}