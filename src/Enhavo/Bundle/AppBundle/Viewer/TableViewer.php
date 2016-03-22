<?php
/**
 * TableViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Viewer;

use Enhavo\Bundle\AppBundle\Exception\PropertyNotExistsException;
use Enhavo\Bundle\AppBundle\Exception\TableWidgetException;

class TableViewer extends AbstractViewer
{
    public function getDefaultConfig()
    {
        return array(
            'table' => array(
                'sorting' => array(
                    'sortable' => false,
                    'move_after_route' => sprintf('%s_%s_move_after', $this->getBundlePrefix(), $this->getResourceName()),
                    'move_to_page_route' => sprintf('%s_%s_move_to_page', $this->getBundlePrefix(), $this->getResourceName())
                )
            )
        );
    }

    protected function getColumns()
    {
        $columns = $this->getConfig()->get('table.columns');
        if (!$columns) {
            if ($this->isSortable()) {
                $columns = array(
                    'id' => array(
                        'label' => 'id',
                        'property' => 'id',
                        'width' => 1
                    ),
                    'position' => array(
                        'label' => '',
                        'property' => 'position',
                        'width' => 1,
                        'widget' => array(
                            'type' => 'template',
                            'template' => 'EnhavoAppBundle:Widget:position.html.twig',
                        )
                    )
                );
            } else {
                $columns = array(
                    'id' => array(
                        'label' => 'id',
                        'property' => 'id',
                        'width' => 1
                    )
                );
            }

        }

        foreach($columns as $key => &$column) {
            if(!array_key_exists('width', $column)) {
                $column['width'] = 1;
            }
        }

        foreach($columns as $key => &$column) {
            if(!array_key_exists('widget', $column)) {
                $column['widget'] = [
                    'type' => 'property'
                ];
            }
        }

        if (isset($columns['position']) && !isset($columns['position']['widget'])) {
            $columns['position']['widget'] = 'EnhavoAppBundle:Widget:position.html.twig';
        }

        return $columns;
    }

    protected function getConfigTableWidth()
    {
        $width = $this->getConfig()->get('table.width');
        if($width === null) {
            return 12;
        }
        return $width;
    }

    protected function getSorting()
    {
        $sorting = $this->getConfig()->get('table.sorting');

        if (!$sorting) {
            $sorting = array();
        }

        if (!isset($sorting['sortable'])) {
            $sorting['sortable'] = false;
        }
        if (!isset($sorting['move_after_route'])) {
            $sorting['move_after_route'] = sprintf('%s_%s_move_after', $this->getBundlePrefix(), $this->getResourceName());
        }
        if (!isset($sorting['move_to_page_route'])) {
            $sorting['move_to_page_route'] = sprintf('%s_%s_move_to_page', $this->getBundlePrefix(), $this->getResourceName());
        }

        return $sorting;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        $parameters = array(
            'viewer' => $this,
            'data' => $this->getResource(),
            'columns' => $this->getColumns(),
            'translationDomain' => $this->getTranslationDomain()
        );

        $parameters = array_merge($this->getTemplateVars(), $parameters);

        return $parameters;
    }

    public function getTableWidth()
    {
        return $this->getConfigTableWidth();
    }

    public function isSortable()
    {
        $sorting = $this->getSorting();
        return $sorting['sortable'] === true;
    }

    public function getMoveAfterRoute()
    {
        $sorting = $this->getSorting();
        return $sorting['move_after_route'];
    }

    public function getMoveToPageRoute()
    {
        $sorting = $this->getSorting();
        return $sorting['move_to_page_route'];
    }

    /**
     * @param $options
     * @param $property
     * @param $item
     * @return string
     * @throws TableWidgetException
     */
    public function renderWidget($options, $property, $item)
    {
        $collector = $this->container->get('enhavo_app.table_widget_collector');
        $widgets = array();
        $widget = $collector->getWidget($options['type']);
        return $widget->render($options, $property, $item);
    }
}
