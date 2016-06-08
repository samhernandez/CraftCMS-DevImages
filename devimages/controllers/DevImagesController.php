<?php
namespace Craft;

class DevImagesController extends BaseController
{
    public function actionIndex()
    {
        $this->requireAjaxRequest();

        $sources = craft()->request->getPost('sources');

        craft()->devImages->generateMissingImages($sources);

        $clearCache = (bool) craft()->request->getPost('clearCache');
        if ($clearCache) {
            craft()->devImages_cache->clear();
        }

        $this->returnJson(['success' => true]);
    }
}
