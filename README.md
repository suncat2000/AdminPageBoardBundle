AdminPageBoardBundle
====================

Symfony2 bundle for generating page-boards in SonataAdminBundle, similar Sonata Admin Dashboard.

Features
------------

- Create custom page-boards similar as SonataAdminBundle `dashboard`
- Configure position (left,center,right, if sonata >= 2.3 then top,bottom) for every block of page-board
- Customization every block (blocks based on SonataBlockBundle) with Twig, Bootstrap and other tools
- Define custom route for every page (custom name, path, host, etc.)
- Pass route params (`$request->get('_route_params')`) into every block settings (`$blockContext->getSettings()['route_params']`)
- Block service for show Entity by configureShowFields() of EntityAdmin class
- `board` action (`_action`) and button with link to page-board in Sonata Admin List view (configureListFields())


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
- Implement adding page-board link to sidebar menu

Example screen
------------
![](https://raw.githubusercontent.com/suncat2000/AdminPageBoardBundle/master/Resources/doc/screen4.png)
- [All screens](https://github.com/suncat2000/AdminPageBoardBundle/tree/master/Resources/doc/screens.md)