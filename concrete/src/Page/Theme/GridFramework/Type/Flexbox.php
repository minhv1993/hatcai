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
            'sm',
            'sm-1',
            'sm-2',
            'sm-3',
            'sm-4',
            'sm-5',
            'sm-6',
            'sm-7',
            'sm-8',
            'sm-9',
            'sm-10',
            'sm-11',
            'sm-12'
        );
        return $columns;
    }

    public function getPageThemeGridFrameworkColumnOffsetClasses()
    {
        $offsets = array(
            'sm-offset-1',
            'sm-offset-2',
            'sm-offset-3',
            'sm-offset-4',
            'sm-offset-5',
            'sm-offset-6',
            'sm-offset-7',
            'sm-offset-8',
            'sm-offset-9',
            'sm-offset-10',
            'sm-offset-11',
            'sm-offset-12'
        );
        return $offsets;
    }

    public function getPageThemeGridFrameworkColumnAdditionalClasses()
    {
        $offsets = array(
            'start-sm',
            'center-sm',
            'end-sm',
            'top-sm',
            'middle-sm',
            'bottom-sm',
            'around-sm',
            'between-sm',
            'first-sm',
            'last-sm',
            'reverse-sm',
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
