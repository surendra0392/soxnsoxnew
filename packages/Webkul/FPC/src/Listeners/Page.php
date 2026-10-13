<?php

namespace Webkul\FPC\Listeners;

use Spatie\ResponseCache\Facades\ResponseCache;
use Webkul\CMS\Repositories\PageRepository;

class Page
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(protected PageRepository $pageRepository) {}

    /**
     * After page update
     *
     * @param  \Webkul\CMS\Contracts\Page  $page
     * @return void
     */
    public function afterUpdate($page)
    {
        ResponseCache::forget('/');

        foreach (core()->getAllLocales() as $locale) {
            if ($pageTranslation = $page->translate($locale->code)) {
                ResponseCache::forget('/page/'.$pageTranslation->url_key);
                ResponseCache::forget('/'.$pageTranslation->url_key);
            }
        }
    }

    /**
     * Before page delete
     *
     * @param  int  $pageId
     * @return void
     */
    public function beforeDelete($pageId)
    {
        $page = $this->pageRepository->find($pageId);

        ResponseCache::forget('/');

        foreach (core()->getAllLocales() as $locale) {
            if ($pageTranslation = $page->translate($locale->code)) {
                ResponseCache::forget('/page/'.$pageTranslation->url_key);
                ResponseCache::forget('/'.$pageTranslation->url_key);
            }
        }
    }
}
