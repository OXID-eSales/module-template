# module-template

[![Build Status](https://img.shields.io/github/workflow/status/OXID-eSales/module-template/CI?logo=github-actions&style=for-the-badge)](https://github.com/OXID-eSales/module-template/actions)

[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/module-template?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/module-template)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/module-template)](https://github.com/oxid-esales/module-template)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)


Reusable module template for extending OXID eShop core functionality.

The module template contains examples for the most common use cases (see below)
like OXID suggests it could be implemented. 

This module also comes with all the quality tools OXID recommends to be used.

## Branch compatibility

* b-6.4.x branch is compatible with OXID eShop compilation b-6.4.x 

## Installation

TODO
* install this module
* clone as template and update prefixes, vendor, namespace via script
* tbd: script for removing example code (clean slate module)


## Idea

OXID eSales would like to provide a lightweight reusable example module incorporating 
our best practices recommendations to be used as a template for developing own module solutions.

Story: 
- Module will extend a block on shop start page to show a greeting message (visible when module is active).
- Module will have a setting to switch between generic greeting message for a logged in user and a personal custom greeting. The Admin's choice which way it will be.
- A logged in user will be able to set a custom greeting depending on module setting. Press the button on start page and be redirected to a module controller which handles the input.
- User custom greetings are saved via shop model save method. We subscribe to BeforeModelUpdate to track how often a user changed his personal greeting.
- Tracking of this information will be done in a new database table to serve as an example for module's own shop model.

### Extend shop functionality

#### Sometimes we just need to extend what the shop is already offering us:
* extending a shop model (`OxidEsales\ModuleTemplate\Model\User`)
* extending a shop controller (`OxidEsales\ModuleTemplate\Controller\StartController`)
* extending a shop database table (`oxuser`)
* extending a shop template block (`start_welcome_text`)

**HINT**: only extend the shop core if there is no other way like listen and handle shop events,
extend/replace some DI service. Your module might be one of many in the class chain and you should 
act accordingly (always ensure to call the parent method and return the result). When extending
shop classes with additional methods, best prefix those methods in order not to end up with another 
module picking the same method name and wreacking havoc.
In case there is no other way than to extend existing shop methods try the minimal invasion principle. 
Put module business logic to a service (which make it easier to test as well) and call the service in the extended shop class.
If you need to extend the shop class chain by overwriting, try to stick to the public methods.

#### Sometimes we need to bring our own
* own module controller (`oetmgreeting` with own template and own translations)
* module setting (`oemoduletemplate_GreetingMode`)
* event subscriber (`OxidEsales\ModuleTemplate\Subscriber\BeforeModelUpdate`)
* model with a database (`OxidEsales\ModuleTemplate\Model\GreetingTracker`)
* DI service examples

#### Whatever you do, ensure it is covered with tests
* unit/integration test
* codeception test
* github actions pipeline
* all the nice quality tools

nice to have for later
* example for payment gateway extension
* own logger
* seo url for module controller ;)
* to redirect or not to redirect from inside the shop core

## Things to be aware of

The template module is intended to act as a tutorial module so keep your eyes open for comments in the code.

**NOTE:** Acceptance tests are way easier to write if you put an id on relevant fields and buttons. 

### Module migrations

* migrations are intended to bump the database (and eventual existing data) to a new module version (this also goes for first time installation).
* ensure migrations are stable against rerun

Migrations have to be run via console command (`./vendor/bin/oe-console` if shop was installed from metapackage, `./bin/oe-console` otherwise)

```bash
./vendor/bin/oe-eshop-doctrine_migration migration:migrate oe_moduletemplate
```
unless we ensure they are run when the module is activated (tied to onActivate event) like done here.

NOTE: Existing migrations must not be changed. If the database needs a change, add a new migration file and change to your needs:

```bash
./vendor/bin/oe-eshop-doctrine_migration migration:generate oe_moduletemplate
```

For more information, check the [developer documentation](https://docs.oxid-esales.com/developer/en/latest/development/tell_me_about/migrations.html).


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

### Writing tests

As a rule of thumb, use codeception tests to ensure the frontend is behaving as expected.
Codeception tests take a while to run, so try to navigate the way between covering the relevant
cases and overtesting. We definitely need some acceptance tests if the module affects the 
frontend like in our example. If the module breaks the frontend, we need to see it asap.
In our case, we cover the reaction of the startpage to the different possibilities
* generic greeting mode (with/without logged in user)
* personal greeting mode (with/without logged in user)
* updating the greeting mode
* ensure module can be activated/deactivated without destroying the shop
* ensure edge case safety like not logged in user directly calling module controller

The great thing about codeception tests is, that they can create screenshot and html
output in failure case, so you literally get a picture of the fail (`tests/Coreception/_output/`).
