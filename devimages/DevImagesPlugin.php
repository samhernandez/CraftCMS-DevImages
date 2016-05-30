<?php
namespace Craft;

class DevImagesPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t('Dev Images');
    }

    public function getVersion()
    {
        return '0.0';
    }

    public function getDeveloper()
    {
        return 'Sam Hernandez';
    }

    public function getDeveloperUrl()
    {
        return 'http://samhernandez.me';
    }

    public function init()
    {
        //
    }
}
