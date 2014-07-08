Installation
============

### Composer

Add to `composer.json` in your project to `require` section:

````
...
    {
        "suncat/admin-page-board-bundle": "dev-master"
    }
...
````

Run command:
`php composer.phar install`

Or run command:
`php composer.phar require suncat/admin-page-board-bundle dev-master`

### Add this bundle to your application's kernel
``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
         // ...
        new Suncat\AdminPageBoardBundle\SuncatAdminPageBoardBundle(),
        // ...
    );
}

```

### Conﬁgure `sonata_block` in your YAML conﬁguration
````
# app/conﬁg/conﬁg.yml
sonata_block:
    default_contexts: [admin]
    blocks:
        sonata.admin.block.admin_list:
            contexts: [admin]
        sonata.block.service.text: ~
````

```

### Conﬁgure `suncat_admin_page_board` in your YAML conﬁguration
````
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
````