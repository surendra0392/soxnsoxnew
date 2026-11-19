<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\View\View;
use Webkul\CMS\Repositories\PageRepository;
use Webkul\Marketing\Repositories\URLRewriteRepository;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected PageRepository $pageRepository,
        protected URLRewriteRepository $urlRewriteRepository
    ) {}

    /**
     * To extract the page content and load it in the respective view file
     *
     * @param  string  $urlKey
     * @return View
     */
    public function view($urlKey)
    {
        $page = $this->pageRepository
            ->whereHas('channels', function ($query) {
                $query->where('channels.id', core()->getCurrentChannel()->id);
            })
            ->whereTranslation('url_key', $urlKey)->first();

        if (! $page) {
            $urlRewrite = $this->urlRewriteRepository->findOneWhere([
                'entity_type' => 'cms_page',
                'request_path' => $urlKey,
                'locale' => app()->getLocale(),
            ]);

            if ($urlRewrite) {
                $targetPath = trim((string) $urlRewrite->target_path);

                if (
                    $targetPath !== ''
                    && ! preg_match('#^https?://#i', $targetPath)
                    && ! str_starts_with($targetPath, '/')
                    && ! str_starts_with($targetPath, 'page/')
                ) {
                    return redirect()->route('shop.cms.page', $targetPath, $urlRewrite->redirect_type);
                }

                return redirect()->to($targetPath, $urlRewrite->redirect_type);
            }

            abort_if(! $page && ! $urlRewrite, 404);
        }

        return view('shop::cms.page')->with('page', $page);
    }
}
