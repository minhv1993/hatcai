<?php

namespace Concrete\Core\Search\Pagination\View;
use \Pagerfanta\View\TwitterBootstrap3View;
use \Concrete\Core\Search\Pagination\View\ViewInterface;
class ConcreteBootstrap3View extends TwitterBootstrap3View implements ViewInterface
{

    protected function createDefaultTemplate()
    {
        return new ConcreteBootstrap3Template();
    }

    public function getArguments()
    {
        $arguments = array(
            'prev_message' => tc('Pagination', 'Prev'),
            'next_message' => tc('Pagination', 'Next'),
            'active_suffix' => '<span class="sr-only">' . tc('Pagination', '(current)') . '</span>'
        );
        return $arguments;
    }

}