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

This module also comes with all the quality tools OXID recommends to use.

## Branch compatibility

* b-6.4.x branch is compatible with OXID eShop compilation b-6.4.x 

## Installation

There are three main goals this repository is intended to help with:

* Install and try out the module with simple examples to most common development questions:
  * Extending of controllers and models
  * Services
  * Migrations
  * Creating templates for your module, extending of oxid theme templates or blocks
  * Using the translations for your module specific phrases
  * Testing your module backend and frontend part
  * Using the github actions as CI tool with all recommended tools preconfigured for you.
* The provided solution can be used as a base for your own module. It will help creating 
  the personalized module base with all the examples listed in the previous point.
* The repository can be used for creating a clean skeleton with only preconfigured 
  OXID recommended quality tools for your new module.

### Install and try it out

Note: This installation method fits for trying out the module development basics,
its not meant to be used as development base for your own module. Check further
installation/usage methods.

This module is in working state and can be directly installed via composer:
```
 composer require oxid-esales/module-template
```

and [activate the module](https://docs.oxid-esales.com/developer/en/6.4/development/modules_components_themes/module/installation_setup/setup.html#setup-activation).

### Use as a base for own module

In case you'd like to use this module as a template for your own module, this section is for you.

Before starting to do something, please, read the whole section once, then decide on required questions, decide 
what you want to achieve, and follow the procedure.

#### Terms

First, lets decide on terms:

* The package name looks like: \<yourVendorName>/\<yourModuleName>, example: oxid-esales/module-template. Decide 
  what will be your new module package name.
* Module is installable to source/modules/\<yourVendorName>/\<yourModuleId> directory, it may differ 
  from the package name. Decide what will be your [module id](https://docs.oxid-esales.com/developer/en/6.4/development/modules_components_themes/module/skeleton/metadataphp/amodule/id.html). It is recommended to use alphanumeric characters and underscores.
* In the following examples, your information required places will be shown as placeholders: \<yourModuleId>, it means
  you should put your module id at that place, without brackets, for example:
  ```
  composer config repositories.<yourPackageName> path source/modules/<yourVendorName>/<yourModuleId>
  ```
  will possibly look like:
  ```
  composer config repositories.my-vendor-name/my-module-name path source/modules/mvn/mvn_mymoduleid
  ```
* In the procedure, we will use our best practices on [module installation for development](https://docs.oxid-esales.com/developer/en/6.4/development/modules_components_themes/module/tutorials/module_setup.html)
  to make your development process as smooth and easy as possible.

#### Procedure

The following procedure describes how to create a base for your further module, and shows the basic 
installation for development process:

1. Click on the "Use this template" button on the template [main page](https://github.com/OXID-eSales/module-template) to 
   create your module repository from the given template. As the outcome, you should have a repository with
   a copy of everything we have in the template repository.

2. Clone your created repository to your local shop modules directory:
   ```
   cd <shopRoot>
   git clone <yourModuleGithubRepositoryUrl> source/modules/<yourVendorName>/<yourModuleId>
   ```

3. Next step is to personalize the original OXID traces with your own vendor, module id, namespace etc. We prepared 
   a script for this, which will prompt you for required information and exchange all main places in the cloned template:
   ```
   cd <shopRoot>
   ./source/modules/<yourVendorName>/<yourModuleId>/bin/personalize.sh
   ```

4. **(Optional)** In case you'd like to have a clean skeleton for your module but keeping all the quality tools,
   test configuraton, github workflows prepared, additionally use the ``cleanexamples.sh`` script, which removes
   all example solutions code.
   ```
    cd <shopRoot>
    ./source/modules/<yourVendorName>/<yourModuleId>/bin/cleanexamples.sh
   ```

5. Register and install your newly created module in the shop
   ```
   cd <shopRoot>
   composer config repositories.<yourPackageName> path source/modules/<yourVendorName>/<yourModuleId>
   composer require <yourPackageName>:*
   ```

6. At this point you have a working module (tests and all) as a starting point to implement whatever you 
   want to extend in your OXID eShop. Initialize and activate the module:
   ```
   cd <shopRoot>
   bin/oe-console oe:module:install source/modules/<yourVendorName>/<yourModuleId>
   bin/oe-console oe:module:activate <yourModuleId>
   ```

7. Try it out if module works, and commit your personalized module changes to your repository:
   ```
   cd <shopRoot>
   cd source/modules/<yourVendorName>/<yourModuleId>
   git commit -am "Personalize the module"
   ```

Likely you'll not need all the example code but you might take some of it
and modify. So we left it there for you to take what you need and clean out all else :)

Please note that the module comes with a database table, translations and some templates which still have the original
names. Just keep an eye on all that's prefixed 'OETM', 'oetm', 'OEMODULETEMPLATE' etc.

Also, you will need to adjust the README, CHANGELOG, LICENSE and the github workflow file, with your credentials and 
names - check the env section there.

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

#### Not yet in here but might come later:
* example for payment gateway extension
* own logger
* seo url for module controller ;)
* to redirect or not to redirect from inside the shop core
* graphql query/mutation example
* extending the internal part
* split by domains

## Things to be aware of

The template module is intended to act as a tutorial module so keep your eyes open for comments in the code.

**NOTES:** 
* Acceptance tests are way easier to write if you put an id on relevant fields and buttons in the templates. 
* If you can, try to develop on OXID eShop Enterprise Edition to get shop aware stuff right from the start.

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

## Running tests and quality tools

Check the ``scripts`` section in the composer.json of the module to get more insight of
preconfigured quality tools available. Example:

```bash
$ composer phpcs
$ composer phpstan
$ composer phpmd
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

### Writing Codeception tests

As a rule of thumb, use codeception tests to ensure the frontend is behaving as expected.
Codeception tests take a while to run, so try to navigate the way between covering the relevant
cases and overtesting. 

We definitely need some acceptance tests if the module affects the 
frontend like in our example. If the module breaks the frontend, we need to see it asap.

In our case, we cover the reaction of the startpage to the different possibilities
* generic greeting mode (with/without logged in user)
* personal greeting mode (with/without logged in user)
* updating the greeting mode
* ensure module can be activated/deactivated without destroying the shop
* ensure edge case safety like not logged in user directly calling module controller

The great thing about codeception tests is - they can create screenshot and html
output in failure case, so you literally get a picture of the fail (`tests/Coreception/_output/`).

**NOTE:** You should add groups to the codeception tests, generic test group for module and then
group by topic. Makes it convenient to just run `vendor/bin/runtests-codeception --group=somegroup`.

### Development Environment - Docker SDK

You can install the shop on whatever system fits your needs, but please check the 
[OXID Docker SDK recipes](https://github.com/OXID-eSales/docker-eshop-sdk-recipes).
That's what we use in OXID Development to quickly set up whatever development environment we need and
we are constantly trying to improve them.

### Useful links

* Vendor home page - https://www.oxid-esales.com
* Bug tracker - https://bugs.oxid-esales.com
* Developer Documentation - https://docs.oxid-esales.com/developer/en/latest/
* Quality Tools and Requirements - https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/quality.html
* Docker SDK recipes - https://github.com/OXID-eSales/docker-eshop-sdk-recipes
* Docker SDK - https://github.com/OXID-eSales/docker-eshop-sdk

### Contact us

* [Open a new issue on our bug tracker](https://bugs.oxid-esales.com)
* [Join our community forum](https://forum.oxid-esales.com/)
* [Use the contact form](https://www.oxid-esales.com/en/contact/contact-us.html)

In case you have any complaints, suggestions, business cases you'd like an example for
please contact us. Pull request are also welcome.  Every feedback we get will help us improve.