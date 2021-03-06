<?php
/**
 * AbstractMenuItem.php
 *
 * @since 20/09/16
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Menu;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Menu
{
    /**
     * @var MenuInterface
     */
    private $menu;

    /**
     * @var array
     */
    private $options;

    public function __construct(MenuInterface $menu, $options)
    {
        $this->menu = $menu;
        $resolver = new OptionsResolver();
        $menu->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function render(array $options = [])
    {
        return $this->menu->render($this->merge($this->options, $options));
    }

    public function getPermission(array $options = [])
    {
        return $this->menu->getPermission($this->merge($this->options, $options));
    }

    public function isHidden(array $options = [])
    {
        return $this->menu->isHidden($this->merge($this->options, $options));
    }

    public function isActive(array $options = [])
    {
        return $this->menu->isActive($this->merge($this->options, $options));
    }

    private function merge($optionsOne, $optionTwo)
    {
        return array_merge($optionsOne, $optionTwo);
    }
}