AdminPageBoardBundle
====================

Symfony2 bundle for generating page-boards in SonataAdminBundle, similar Sonata Admin Dashboard.

Features
------------

* Create custom page-boards similar as dashboard page of SonataAdminBundle
* Configure position (left,center,right, if sonata >= 2.3 then top,bottom) for every block of page-board
* Customization every block (blocks based on SonataBlockBundle) with Twig, Bootstrap and another tools
* Define custom route for every page (custom name, path, host, etc.)
* Pass route params (`$request->attributes->get('_route_params')`) into every block settings (`$blockContext->getSettings()['route_params']`)


Documentation
------------

The bulk of the documentation is stored in the `Resources/doc/index.md` file in this bundle:

[Read the Documentation](https://github.com/suncat2000/AdminPageBoardBundle/tree/master/Resources/doc/index.md)

Installation
------------

Installation instruction are located in the [documentation](https://github.com/suncat2000/AdminPageBoardBundle/tree/master/Resources/doc/index.md)

Sandbox
------------

[Sandbox](https://github.com/suncat2000/admin-page-board-sandbox) for AdminPageBoardBundle

TODO
------------

- Write Tests
- Add prepared block service for view entity data by configureShowFields() of EntityAdmin class
- Add prepared list actions
- Improve opportunities for least manual work (writing code)
