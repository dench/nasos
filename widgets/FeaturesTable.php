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

class FeaturesTable extends Widget
{
    public $variants;

    public $theadText;

    public $options = ['class' => 'table table-striped'];

    function run()
    {
        $cols[] = Html::tag('th', $this->theadText);

        $values = [];
        $labels = [];
        $after = [];

        $sortable = [];

        $count = count($this->variants);

        foreach ($this->variants as $variant) {
            $cols[] = Html::tag('th', $variant->name);

            foreach ($variant->values as $value) {
                if (!isset($rows2[$value->feature_id])) {
                    $labels[$value->feature_id] = $value->feature->name;
                    $after[$value->feature_id] = $value->feature->after;
                    $sortable[$value->feature_id] = $value->feature->position;
                }
                $values[$value->feature_id][$variant->id][] = $value->name;
            }
        }

        $feature = [];

        foreach ($values as $key => $variant) {
            //$old_var = 0;
            $old_value = 0;
            $marge = 1;
            $feature[$key]['label'] = $labels[$key];
            if (!empty($after[$key])) {
                $feature[$key]['label'] .= ', ' . $after[$key];
            }
            foreach ($variant as $var => $val) {
                $value = implode(', ', $val);
                if ($old_value === $value) {
                    $marge++;
                }
                $colspan = 0;
                if ($marge == $count) {
                    unset($feature[$key]['cols']);
                    $colspan = $count;
                }
                $feature[$key]['cols'][$var] = [
                    'colspan' => $colspan,
                    'value' =>  $value,
                ];
                //$old_var = $var;
                $old_value = $value;
            }
        }

        $thead = Html::tag('tr', implode("\n", $cols));

        $rows = [];

        foreach ($feature as $k => $f) {
            $cols = [];
            $cols[] = Html::tag('th', $f['label']);
            foreach ($f['cols'] as $col) {
                $options = ($col['colspan'] > 1) ? ['colspan' => $col['colspan']] : [];
                $cols[] = Html::tag('td', $col['value'], $options);
            }
            $rows[$k] = Html::tag('tr', implode("\n", $cols));
        }

        asort($sortable);

        $rows_sortable = [];

        foreach ($sortable as $key => $sort) {
            $rows_sortable[$key] = $rows[$key];
        }

        $tbody = implode("\n", $rows_sortable);

        $table = strtr('<thead>{thead}</thead><tbody>{tbody}</tbody>', [
            '{thead}' => $thead,
            '{tbody}' => $tbody,
        ]);
        return Html::tag('table', $table, $this->options);
    }
}