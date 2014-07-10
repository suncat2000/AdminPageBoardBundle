Installation
------------

### Composer

Add to `composer.json` in your project to `require` section:

```json
{
    "suncat/admin-page-board-bundle": "dev-master"
}   
```

Run command:
`php composer.phar install`

Or run command:
`php composer.phar require suncat/admin-page-board-bundle dev-master`

#### Add this bundle to your application's kernel
``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        // SONATA
        new Sonata\CoreBundle\SonataCoreBundle(),
        new Sonata\BlockBundle\SonataBlockBundle(),
        new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
        new Sonata\AdminBundle\SonataAdminBundle(),
        // SUNCAT
        new Suncat\AdminPageBoardBundle\SuncatAdminPageBoardBundle(),
        // ...
    );
}

```

#### Define routes 
```yaml
# app/config/routing.yml
_suncat_admin_page_board:
    resource: .
    type: sonata_admin_page_board
    prefix: /admin
```

#### Conﬁgure `sonata_block` in your YAML conﬁguration
```yaml
# app/conﬁg/conﬁg.yml
sonata_block:
    default_contexts: [admin]
    blocks:
        sonata.admin.block.admin_list:
            contexts: [admin]
        sonata.block.service.text: ~
```

#### Conﬁgure `suncat_admin_page_board` in your YAML conﬁguration
```yaml
# app/conﬁg/conﬁg.yml
suncat_admin_page_board:
    page_boards:
        test_page_board:
            blocks:
                -
                    position: left
                    type: sonata.block.service.text
                    settings:
                        content: >
                            Some text of block
            route:
                name: admin_suncat_test_page_board
                path: /suncat/admin/test/board
```