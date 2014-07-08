Usage example with entity data in block
------------

### Create your Block service class

``` php
// src/Namespace/YourBundle/Block/EntityBlockService.php
<?php

namespace Namespace\YourBundle\Block;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class EntityBlockService
 */
class EntityBlockService extends BaseBlockService
{
    protected $entityManager;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param EntityManager $entityManager
     */
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);

        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Entity';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'YourBundle:Block:block_entity.html.twig',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        if (null === $settings['route_params']) {
            throw new \RuntimeException('Route params is null');
        }
        if (!isset($settings['route_params']['id'])) {
            throw new \RuntimeException('Id route param is not exist');
        }

        $id = (int) $settings['route_params']['id'];

        $entity = $this->entityManager->getRepository('YourBundle:Entity')->findOneBy(['id' => $id]);

        if (null === $entity) {
            throw new \RuntimeException('Entity not found');
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'entity'     => $entity,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }
}

```

### Define DI block service

```xml
<?xml version="1.0" ?>
<!-- src/Namespace/YourBundle/Resources/config/sonata_block.xml -->

<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="your_bundle.admin.block.entity.class">Namespace\YourBundle\Block\EntityBlockService</parameter>
    </parameters>

    <services>
        <service id="your_bundle.admin.block.entity" class="%your_bundle.admin.block.entity.class%">
            <argument>your_bundle.admin.block.entity</argument>
            <argument type="service" id="templating" />
            <argument type="service" id="doctrine.orm.entity_manager" />
            <tag name="sonata.block" />
        </service>
    </services>
</container>

```

### Create block twig template

````
{# src/Namespace/YourBundle/Resources/views/Block/block_entity.html.twig #}

{% extends sonata_block.templates.block_base %}

{% block block %}
    <h4 class="entity-data-title">{{ settings.title }}</h4>
    <hr style="margin-top:0;">

    <div class="entity-data-container">
        {% if entity %}
            <div class="row">
                <div class="col-md-8">
                    <strong style="font-size: 18px;">#{{ entity.id }} - {{ entity.title }}</strong>
                </div>
                <div class="col-md-4">
                    <div class="sonata-actions btn-group">
                        <a class="btn btn-sm btn-default sonata-action-element" href="{{ path('sonata_admin_entity_route_name_edit', {id: entity.id}) }}">
                            <i class="fa fa-pencil-square-o"></i> Edit
                        </a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped" style="margin-top: 10px;">
                        <tr>
                            <td>Enabled</td><td>{{ entity.enabled ? '<span class="label label-success">yes</span>' : '<span class="label label-important">no</span>' }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td><td>{{ entity.createdAt|date("m/d/Y") }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td><td>{{ entity.updatedAt|date("m/d/Y") }}</td>
                        </tr>
                        <tr>
                            <td>Text</td><td>{{ entity.text }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        {% else %}
            Entity is empty
        {% endif %}
    </div>
{% endblock %}
````

### Add block to page-board configuration

````
# app/conﬁg/conﬁg.yml
suncat_admin_page_board:
    page_boards:
        entity_board:
            blocks:
                -
                    position: left
                    type: your_bundle.admin.block.entity
                    settings:
                        title: Entity board page
            route:
                name: admin_namespace_your_entity_board
                path: /namespace/your/entity/{id}/board
                requirements:
                    id:  \d+
````

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

### Click on `Board` button and look something this

![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen1.png)
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen2.png)