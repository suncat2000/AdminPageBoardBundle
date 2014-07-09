Override page-board template
------------

#### Set options `page_board_template` in configuration
```yaml
# app/conﬁg/conﬁg.yml
suncat_admin_page_board:
    page_boards:
        ...
        page_board_template: "YourBundle:Core:page_board.html.twig"   # override board template
```

#### Create page-board template
 
.. code-block:: jinja
    {# src/Namespace/YourBundle/Resources/views/Core/page_board.html.twig #}
    
    {% extends 'SuncatAdminPageBoardBundle:Core:page_board.html.twig' %}
    {# extends 'SonataAdminBundle:Core:dashboard.html.twig' #}
    
    {# override blocks#}
    {% block title %}{% endblock%}
    
    {% block breadcrumb %}{% endblock %}
    
    {% block content %}{% endblock %}