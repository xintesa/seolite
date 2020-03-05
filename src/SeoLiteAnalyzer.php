<?php

namespace Seolite;

use Croogo\Core\Utility\StringConverter;

class SeoLiteAnalyzer
{
    public function analyze($text)
    {
        $params = ['content' => $text];
        $keywords = '';

        $para = trim(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));

        $description = (new StringConverter())->firstPara($para);

        return compact('keywords', 'description');
    }
}
