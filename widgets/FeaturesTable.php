<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 18.03.17
 * Time: 15:03
 */

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Html;

class FeaturesTable extends Widget
{
    public $variants;

    public $theadText;

    public $options = ['class' => 'table table-striped'];

    function run()
    {
        $variants = [];

        foreach ($this->variants as $variant) {
            if ($variant->enabled) {
                $variants[] = $variant;
            }
        }

        if (empty($this->variants)) {
            return '';
        }

        $cols[] = Html::tag('th', $this->theadText);

        $values = [];
        $labels = [];
        $after = [];

        $sortable = [];

        $count = count($variants);

        foreach ($variants as $variant) {
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
        $rows_hide = [];

        foreach ($sortable as $key => $sort) {
            $rows_sortable[$key] = $rows[$key];
        }

        $hide = 18;
        $tpl = '<thead>{thead}</thead><tbody>{tbody}</tbody>';

        if (count($rows_sortable) > $hide) {
            $rows_hide = array_slice($rows_sortable, $hide, null, true);
            $rows_sortable = array_slice($rows_sortable, 0, $hide, true);
            $tpl = '<thead>{thead}</thead><tbody>{tbody}</tbody><tbody class="features-hidden" style="display: none;">{tbody_hide}</tbody><tbody><tr><th colspan="'.($count+1).'"><a class="showFeaturesAll" href="#">'.Yii::t('app', 'Show all features').' <i class="glyphicon glyphicon-arrow-down"></i></a><a class="hideFeaturesAll" href="#">'.Yii::t('app', 'Hide features').' <i class="glyphicon glyphicon-arrow-up"></i></a></th></tr></tbody>';
            $js = <<<JS
$('.showFeaturesAll').click(function(e){
    e.preventDefault();
    $('.showFeaturesAll').hide();
    $('.hideFeaturesAll').show();
    $('.features-hidden').show('slow');
});
$('.hideFeaturesAll').click(function(e){
    e.preventDefault();
    $('.features-hidden').hide('slow', function(){
        $('.hideFeaturesAll').hide();
        $('.showFeaturesAll').show();
    });
});
JS;
            Yii::$app->view->registerJs($js);
        }

        $tbody = implode("\n", $rows_sortable);
        $tbody_hide = implode("\n", $rows_hide);

        $table = strtr($tpl, [
            '{thead}' => $thead,
            '{tbody}' => $tbody,
            '{tbody_hide}' => $tbody_hide,
        ]);
        return Html::tag('table', $table, $this->options);
    }
}