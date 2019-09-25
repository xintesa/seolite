<?php

namespace Seolite;

use Croogo\Core\Utility\StringConverter;

class SeoLiteAnalyzer
{
    public function analyze($text)
    {
        $params = ['content' => $text];
        $analyzer = new \colossal_mind_mb_keyword_gen($params);
        $keywords = $analyzer->get_keywords();

        $para = trim(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));

        $description = (new StringConverter())->firstPara($para);

        return compact('keywords', 'description');
    }
}
