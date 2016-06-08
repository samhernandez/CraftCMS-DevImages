<?php

namespace Craft;

class DevImagesService extends BaseApplicationComponent
{
    /**
     * Generates randomly colored images present in the database but
     * not in the filesystem.
     *
     * @param $sourceIds array
     */
    public function generateMissingImages($sourceIds = null)
    {
        if ($sourceIds === null)
        {
            return;
        }

        // Get all the source paths first so we don't have to get them
        // while iterating through image assets.
        $paths = [];
        $sources = craft()->assetSources->getAllSources();
        foreach ($sources as $source) {
            if (in_array($source['id'], $sourceIds)) {
                $paths[$source['id']] = craft()->config->parseEnvironmentString($source['settings']['path']);
            }
        }
        
        // Get all image asset elements for the selected source IDs
        $criteria = craft()->elements->getCriteria(ElementType::Asset);
        $criteria->kind = 'image';
        $criteria->limit = null;
        $criteria->sourceId = $sourceIds;
        $images = $criteria->find();

        // Generate images for missing files
        foreach ($images as $asset)
        {
            /** @var AssetFileModel $asset */
            $path = $paths[$asset['sourceId']] . $asset->getPath();
            if ( ! IOHelper::fileExists($path)) {
                craft()->devImages_image->createAndSave($asset->width, $asset->height, $path);
            }
        }
    }
}
