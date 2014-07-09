### Configuration reference

```yaml
# app/conﬁg/conﬁg.yml
suncat_admin_page_board:
    page_boards:
        news_board:   # page key/id
            blocks:
                -
                    position: left    # block position: left,center,right, for sonata >= 2.3 top,bottom
                    type: suncat_admin.admin.block.news_detail    # your `sonata.block` service
                    settings:    # block settings
                        title: News detail
            route:
                name: admin_suncat_admin_news_board             # route name (default )
                path: /suncat/admin/news/{id}/board             # *required
                prefix: '/admin'                                # route path prefix (default: /admin)
                routes_prefix_name: 'sonata_admin_page_board'   # route name prefix (default)
                host: 'site.com'
                schemes: 'http,https'
                requirements:
                    id:  \d+
        another_page:
            blocks:
                -
                    position: left
                    type: sonata.block.service.text
                    settings:
                        content: Some text
                -
                    position: right
                    type: sonata.block.service.text
                    settings:
                        content: Some text
            route:
                name: admin_suncat_another_page
                path: /suncat/admin/another/page
        routes_loader_class: "Suncat\AdminPageBoardBundle\Routing\RouteLoader"              # override route loader
        routes_config_class: "Suncat\AdminPageBoardBundle\Routing\RouteConfig"              # override route config
        page_board_template: "SuncatAdminPageBoardBundle:Core:page_board.html.twig"         # override board template 
        sonata_admin_layout_template: "SuncatAdminPageBoardBundle::layout.html.twig"        # override sonata layout 
        sonata_admin_list_builder_class: "Suncat\AdminPageBoardBundle\Builder\ListBuilder"  # override list builder
        sonata_admin_version: 2.3 (default)                                           # 2.2 left,center,right grid
                                                                                      # 2.3 top,left,center,right,bottom
```