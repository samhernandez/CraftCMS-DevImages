<?php
namespace Craft;

class DevImagesController extends BaseController
{
    public function actionIndex()
    {
        $this->requireAjaxRequest();

        craft()->devImages->generateMissingImages();

        $clearCache = (bool) craft()->request->getPost('clearCache');
        if ($clearCache) {
            craft()->devImages_cache->clear();
        }

        $this->returnJson(['success' => true]);
    }
}
