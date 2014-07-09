Custom Sonata Admin List view action button
------------

### Add custom `list` action button for EntityAdmin

```php
<?php

namespace Namespace\YourBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * Class EntityAdmin
 */
class EntityAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('field1')
            ->add('field2')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'entity_board' => array('template' => 'YourBundle:Admin/CRUD:list__action_entity_board.html.twig'),
                )
            ))
        ;
    }
    ...
}
```

### Create custom action template

````
{# src/Namespace/YourBundle/Resources/views/Admin/CRUD/list__action_entity_board.html.twig #}
{% if admin.isGranted('VIEW', object) and admin.hasRoute('show') %}
    <a href="{{ path('admin_namespace_your_entity_board', {id: object.id}) }}" class="btn btn-sm btn-default view_link" title="Show entity board">
        <i class="fa fa-tachometer"></i> Board
    </a>
{% endif %}
````
