<?php

namespace app\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Breadcrumbs with Microdata markup from Schema.org
 * @supplemented Max <anywebdev@gmail.com>
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $itempropPosition = 1;

    public $itemOptions = [];

    public $linkOptions = [];

    public $lastOptions = [];

    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        $links = [];

        $replacement = ['>{link}' => ' itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">{link}{position}'];

        //todo: , '<img ' => '<img itemprop="image" '

        $this->itemTemplate = strtr($this->itemTemplate, $replacement);

        $this->activeItemTemplate = strtr($this->activeItemTemplate, $replacement);

        if ($this->homeLink === null) {
            $links[] = $this->renderItemMarkup(
                [
                    'label' => Yii::$app->name,
                    'url' => Yii::$app->homeUrl,
                ],
                $this->itemTemplate,
                $this->itempropPosition
            );
        } elseif ($this->homeLink !== false) {
            $this->homeLink['template'] = isset($this->homeLink['template']) ? strtr($this->homeLink['template'], $replacement) : $this->itemTemplate;
            $links[] = $this->renderItemMarkup(
                $this->homeLink,
                $this->homeLink['template'],
                $this->itempropPosition
            );
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItemMarkup(
                $link,
                isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate,
                ++$this->itempropPosition
            );
        }

        echo Html::tag(
            $this->tag,
            implode('', $links),
            array_merge(
                $this->options,
                ["itemscope itemtype" => "http://schema.org/BreadcrumbList"]
            )
        );
    }

    protected function renderItemMarkup($link, $template, $position)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);

        if (array_key_exists('label', $link)) {
            $this->itemOptions['itemprop'] = 'name';
            $label = Html::tag('span', $encodeLabel ? Html::encode($link['label']) : $link['label'], $this->itemOptions);
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $this->linkOptions['itemprop'] = 'item';
            $link = Html::a($label, $link['url'], array_merge($options, $this->linkOptions));
        } else {
            $this->lastOptions['itemprop'] = 'item';
            $this->lastOptions['href'] = Url::current();
            $link = Html::tag('link', null, $this->lastOptions) . $label;
        }

        return strtr($template,
            [
                '{link}' => $link,
                '{position}' => Html::tag('meta', '', ['itemprop' => 'position', 'content' => $position])
            ]
        );
    }
}
