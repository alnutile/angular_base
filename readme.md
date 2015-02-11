# Angular Base

A command to setup a base Angular Project

Using the [John Pappa Guide](https://github.com/johnpapa/angularjs-styleguide)

Running

~~~
php artisan angular-base:generate foo
~~~

Will make

public/js/foo
public/js/foo/config.txt                         -- ui router based settings
public/js/foo/service.js                        -- restangular based crud
public/js/foo/indexController.js                -- index for resource
public/js/foo/templates/index.html              -- starting page
public/js/foo/templates/create_edit_modal.html  -- modal to edit and create resource
public/js/foo/helper.js                         -- helper for centralizing some shared functions

