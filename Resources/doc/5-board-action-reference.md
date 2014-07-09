Full options list for `board` action of Sonata Admin List view
------------

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
                    'board' => array(                                   # reserved type of action as show,edit
                        'route' => 'your_route_name',                   # route name of page-board
                        'label' => 'Label',                             # label|trans
                        'label_catalogue' => 'YourBundle',              # label|trans({}, label_catalogue)
                        'icon' => '<i class="fa fa-tachometer"></i>',   # icon button html
                        'route_object_id_param' => 'id'                 # (default, change to 'newsId', if route path .../admin/news/{newsId}/board)
                    ),
                    'custom_board' => array(                            # custom action, need set 'type' option
                        'type' => 'page_board',                         # page_board action type, if used 'custom_board' name
                        'route' => 'your_route_name',                   # route name of page-board
                        ...
                    ),
                )
            ))
        ;
    }
    ...
}
```