<?php

namespace Craft;

class DevImages_GenerateWidget extends BaseWidget
{

	/**
	 * @var bool
	 */
	public $multipleInstances = false;

    public function getName()
    {
        return Craft::t('Generate Missing Images');
    }

    public function getBodyHtml()
    {
        if ( ! craft()->userSession->isAdmin()) {
            return false;
        }

		$sourceList = $this->_getSourceList();

        craft()->templates->includeJsResource('devimages/js/devimages.js');
        return craft()->templates->render('devimages/_widget', array(
	        'sourceList' => $sourceList
        ));
    }

	private function _getSourceList()
	{
		$sources = craft()->assetSources->getAllSources();

		$sourceList = [];
		foreach ($sources as $source)
		{
			$sourceList[$source->id] = [];
			$sourceList[$source->id]['source'] = $source;
			$sourceList[$source->id]['valid'] = true;

			$path = craft()->config->parseEnvironmentString($source['settings']['path']);

			if (strpos($path,'{') !== false) {
				$sourceList[$source->id]['valid'] = false;
			}

			if ($sourceList[$source->id]['valid'] && !IOHelper::folderExists($path)) {
				$sourceList[$source->id]['valid'] = false;
			}
		}

		return $sourceList;
	}
}
