<?php
/* @var $this yii\web\View */
/* @var $urls array */

echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

foreach ($urls as $url) {
    echo '<url>';
    echo '<loc>' . $url['loc'] . '</loc>';
    if (!empty($url['lastmod'])) {
        echo '<lastmod>' . $url['lastmod'] . '</lastmod>';
    }
    echo '</url>';
}

echo '
</urlset>';