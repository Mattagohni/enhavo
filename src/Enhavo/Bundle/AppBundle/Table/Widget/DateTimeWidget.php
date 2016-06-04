<?php
/**
 * Created by PhpStorm.
 * User: jhelbing
 * Date: 02.02.16
 * Time: 11:10
 */

namespace Enhavo\Bundle\AppBundle\Table\Widget;

use Enhavo\Bundle\AppBundle\Table\AbstractTableWidget;

class DateTimeWidget extends AbstractTableWidget
{
    public function render($options, $item)
    {
        $property = $this->getProperty($item, $options['property']);
        return $property->format('d.m.Y H:i');
    }

    public function getType()
    {
        return 'datetime';
    }
}