<?php

namespace Craft;

class DevImages_GenerateWidget extends BaseWidget
{
    public function getName()
    {
        return Craft::t('Generate Missing Images');
    }

    public function getBodyHtml()
    {
        if ( ! craft()->userSession->isAdmin()) {
            return false;
        }

        craft()->templates->includeJsResource('devimages/js/devimages.js');
        return craft()->templates->render('devimages/_widget');
    }
}
