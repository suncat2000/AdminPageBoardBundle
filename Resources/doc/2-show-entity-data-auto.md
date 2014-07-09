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
                        sonata_admin_code: suncat_admin.admin.news  # *required
                        sonata_admin_object_id_param: 'id'          # (default, change to 'newsId', if route path .../admin/news/{newsId}/board)
                        btn_add: true|false (default true)          # show Add new entity btn
                        btn_edit: true|false (default true)         # show Edit entity btn
                        btn_list: true|false (default true)         # show List entities btn
                -
                    position: left
                    type: suncat_admin.admin.block.news_detail
                    settings:
                        title: News detail (manual)
                -
                    position: right
                    type: suncat_admin.admin.block.news_comments
                    settings:
                        title: News comments
                -
                    position: right
                    type: suncat_admin.admin.block.news_tags
                    settings:
                        title: News tags
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

### add custom `list` action button

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

### Click on `Board` button
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen2.png)

### Look something this
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen4.png)