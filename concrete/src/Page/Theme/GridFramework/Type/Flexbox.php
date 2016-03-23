<?php
namespace Concrete\Core\Page\Theme\GridFramework\Type;

use Loader;
use Concrete\Core\Page\Theme\GridFramework\GridFramework;

class Flexbox extends GridFramework
{

    public function supportsNesting()
    {
        return true;
    }

    public function getPageThemeGridFrameworkName()
    {
        return t('Flexbox');
    }

    public function getPageThemeGridFrameworkRowStartHTML()
    {
        return '<div class="row">';
    }

    public function getPageThemeGridFrameworkRowEndHTML()
    {
        return '</div>';
    }

    public function getPageThemeGridFrameworkContainerStartHTML()
    {
        return '<div class="container">';
    }

    public function getPageThemeGridFrameworkContainerEndHTML()
    {
        return '</div>';
    }

    public function getPageThemeGridFrameworkColumnClasses()
    {
        $columns = array(
            'xs-1',
            'xs-2',
            'xs-3',
            'xs-4',
            'xs-5',
            'xs-6',
            'xs-7',
            'xs-8',
            'xs-9',
            'xs-10',
            'xs-11',
            'xs-12'
        );
        return $columns;
    }

    public function getPageThemeGridFrameworkColumnOffsetClasses()
    {
        $offsets = array(
            'xs-offset-1',
            'xs-offset-2',
            'xs-offset-3',
            'xs-offset-4',
            'xs-offset-5',
            'xs-offset-6',
            'xs-offset-7',
            'xs-offset-8',
            'xs-offset-9',
            'xs-offset-10',
            'xs-offset-11',
            'xs-offset-12'
        );
        return $offsets;
    }

    public function getPageThemeGridFrameworkColumnAdditionalClasses()
    {
        $offsets = array(
            'start-xs',
            'center-xs',
            'end-xs',
            'top-xs',
            'middle-xs',
            'bottom-xs',
            'around-xs',
            'between-xs',
            'first-xs',
            'last-xs',
            'reverse-xs',
        );
        return '';
    }

    public function getPageThemeGridFrameworkColumnOffsetAdditionalClasses()
    {
        return '';
    }

    public function getPageThemeGridFrameworkHideOnExtraSmallDeviceClass()
    {
        return 'hidden-xs';
    }

    public function getPageThemeGridFrameworkHideOnSmallDeviceClass()
    {
        return 'hidden-sm';
    }

    public function getPageThemeGridFrameworkHideOnMediumDeviceClass()
    {
        return 'hidden-md';
    }

    public function getPageThemeGridFrameworkHideOnLargeDeviceClass()
    {
        return 'hidden-lg';
    }


}
