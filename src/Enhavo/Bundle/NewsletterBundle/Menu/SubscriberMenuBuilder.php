<?php
/**
 * SubscriberMenuBuilder.php
 *
 * @since 21/09/16
 * @author gseidel
 */

namespace Enhavo\Bundle\NewsletterBundle\Menu;

use Enhavo\Bundle\AppBundle\Menu\Builder\BaseMenuBuilder;

class SubscriberMenuBuilder extends BaseMenuBuilder
{
    public function createMenu(array $options)
    {
        $this->setOption('icon', $options, 'user-plus');
        $this->setOption('label', $options, 'subscriber.label.subscriber');
        $this->setOption('translationDomain', $options, 'EnhavoNewsletterBundle');
        $this->setOption('route', $options, 'enhavo_newsletter_subscriber_index');
        $this->setOption('role', $options, 'ROLE_ADMIN_ENHAVO_NEWSLETTER_SUBSCRIBER_INDEX');
        return parent::createMenu($options);
    }

    public function getType()
    {
        return 'newsletter_subscriber';
    }
}