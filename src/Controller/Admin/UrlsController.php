<?php

/**
 * SeoLiteUrls Controller
 *
 * @property SeoLiteUrl $SeoLiteUrl
 * @property PaginatorComponent $Paginator
 */
namespace Seolite\Controller\Admin;

class UrlsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg');
    }
}
