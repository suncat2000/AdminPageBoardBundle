Show entity by data from configureShowFields()
------------

### Add block to page-board configuration

````
# app/conﬁg/conﬁg.yml
suncat_admin_page_board:
    page_boards:
        news_detail:
            blocks:
                -
                    position: left
                    type: suncat_admin_page_board.admin.block.admin_show
                    settings:
                        title: News detail (admin show)
                        sonata_admin_code: suncat_admin.admin.news  # (*required) Sonata Admin service name
                        sonata_admin_object_id_param: 'id'          # (default) change to 'newsId', if route path .../admin/news/{newsId}/board)
                        btn_add: true|false (default true)          # show Add new entity btn
                        btn_edit: true|false (default true)         # show Edit entity btn
                        btn_list: true|false (default true)         # show List entities btn
                ...
            route:
                name: admin_suncat_admin_news_board
                path: /suncat/admin/news/{id}/board
                requirements:
                    id:  \d+
````

### Define configureShowFields() method in EntityAdmin class

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
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
                ->add('enabled')
                ->add('title')
                ->add('text')
            ->end()
            ->with('Timestampable')
                ->add('createdAt')
                ->add('updatedAt')
            ->end()
        ;
    }
    ...
```

### add `board` action button

```php
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
                        'board' => array('route' => 'admin_namespace_your_entity_board'),  # route name of page-board
                    )
                ))
            ;
        }
    ...
}
```

#### Board action

- [Full options list for 'board' action](5-board-action-reference.md)
- [Custom Sonata List view action button](4-custom-sonata-list-action-button.md)


### Click on `Board` button
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen2.png)

### Look something this
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen4.png)