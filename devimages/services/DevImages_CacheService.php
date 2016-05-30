<?php

namespace Craft;

class DevImages_CacheService extends BaseApplicationComponent
{
	/**
	 * Clears all asset caches utilizing `ClearCachesTool`
	 */
	public function clear()
	{
		$assetsRuntimeFolder = craft()->path->getRuntimePath().'assets';
		$params = [
			'caches' => [
				md5($assetsRuntimeFolder),
				'assettransformindex',
				'assetIndexingData',
			],
			'start' => true,
		];

		$tool = craft()->components->getComponentByTypeAndClass(ComponentType::Tool, 'ClearCaches');
		$tool->performAction($params);
	}
}
