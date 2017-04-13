<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 18.03.17
 * Time: 15:03
 */

namespace app\widgets;

use yii\base\Widget;
use yii\bootstrap\Html;

class FeaturesSimpleTable extends Widget
{
    public $variants;

    public $theadText;

    public $options = ['class' => 'table table-striped'];

    function run()
    {

        $labels = [];

        $rows = [];

        foreach ($this->variants as $variant) {
            $cols = [];
            foreach ($variant->values as $value) {
                //$cols[$value->feature_id] = Html::tag(/*$cols ? 'td' : 'th'*/'td', $value->name);
                $cols[$value->feature->position] = $value->name;
                $labels[$value->feature->position] = Html::tag('th', $value->feature->name . ($value->feature->after ? ', ' . $value->feature->after : ''));
            }
            if ($variant->price) {
                //$cols[0] = Html::tag('td', $variant->price);
                $cols[0] = $variant->price;
                $labels[0] = Html::tag('th', \Yii::t('app', 'Price') . ', ' . \Yii::t('app', 'UAH'));
            }
            ksort($cols);
            $th = 1;
            foreach ($cols as $k => $v) {
                $cols[$k] = Html::tag($th ? 'th' : 'td', $v);
                $th = 0;
            }
            $rows[$variant->id] = Html::tag('tr', implode("\n", $cols));
        }

        ksort($labels);
        $thead = Html::tag('tr', implode("\n", $labels));
        $tbody = implode("\n", $rows);

        $table = strtr('<thead>{thead}</thead><tbody>{tbody}</tbody>', [
            '{thead}' => $thead,
            '{tbody}' => $tbody,
        ]);

        return Html::tag('table', $table, $this->options);
    }
}