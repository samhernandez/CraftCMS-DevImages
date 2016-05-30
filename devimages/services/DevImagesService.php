<?php

namespace Craft;

class DevImagesService extends BaseApplicationComponent
{
	/**
	 * Generates randomly colored images present in the database but
	 * not in the filesystem.
	 */
	public function generateMissingImages()
	{
		// Get all the source paths first so we don't have to get them
		// while iterating through image assets.
		$paths = [];
		$sources = craft()->assetSources->getAllSources();
		foreach($sources as $source) {
			$paths[$source['id']] = $source['settings']['path'];
		}

		// Get all image asset elements
		$images = craft()->elements->getCriteria(ElementType::Asset, ['kind' => 'image'])->findAll();

		// Generate images for missing files
		foreach($images as $asset)
		{
			$path = $paths[$asset['sourceId']] . $asset->getPath();
			if ( ! IOHelper::fileExists($path)) {
				craft()->devImages_image->createAndSave($asset->width, $asset->height, $path);
			}
		}
	}
}
