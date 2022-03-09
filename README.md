# module-template

Reusable module template for extending OXID eShop core functionality.

## Branch compatibility

* b-6.4.x branch is compatible with OXID eShop compilation b-6.4.x 

## Idea

OXID eSales would like to provide a lightweight reusable example module incorporating our best practices recommendations 
to be used as a template for developing own module solutions.

### Extend shop functionality

#### Sometimes we just need to extend what the shop is already offering us:
* extending a shop model
* extending a shop controller
* extending a shop database table
* extending a shop template block 
* extending shop core functionality (payment gateway)

**HINT**: only extend the shop core if there is no other way like listen and handle shop events,
extend/replace some DI service. Your module might be one of many in the class chain and you should 
act accordingly (always ensure to call the parent method and return the result). When extending
shop classes with additional methods, best prefix those methods in order not to end up with another 
module picking the same method name and wreacking havoc.
In case there is no other way than to extend existing shop methods (we will add an example for 
the payment gateway) try the minimal invasion principle. Put module business logic to a service
(which make it easier to test as well) and call the service in the extended shop class.
If you need to extend the shop class chain by overwriting, try to stick to the public methods.

#### Sometimes we need to bring our own
* own module controller (with own template and own translations)
* own module model with own database table

#### Whatever you do, ensure it is covered with tests
* unit test
* integration test
* codeception test
* github actions pipeline
* all the nice quality tools

todo: module setting

nice to have
* an event listener/handler

## Things to be aware of

### Module migrations

* migrations are intended to bump the database (and eventual existing data) to a new module version (this also goes for first time installation).
* ensure migrations are stable against rerun

Migrations have to be run via console command

```bash
./vendor/bin/oe-eshop-doctrine_migration migration:migrate oe_moduletemplate
```
unless we ensure they are run when the module is activated (tied to onActivate event) like done here.

### Where the module namespace points to
In the 6.x versions of OXID eShop, the module code is copied to source/modules directory and the module's metadata 
and yaml files will be taken from there. This means some module code will be duplicated from vendor directory to 
shop source/modules directory. 
NOTE: In our example the module namespace points to the vendor directory.

## Running tests

## Testing

### Linting, syntax check, static analysis and unit tests

```bash
$ composer update
$ composer test
```

### Integration/Acceptance tests

- install this module into a running OXID eShop
- change the `test_config.yml`
    - add `oe/moduletemplate` to the `partial_module_paths`
    - set `activate_all_modules` to `true`

```bash
$ vendor/bin/runtests
$ vendor/bin/runtests-codeception
```
