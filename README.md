# OXID eShop Module Template

[![Development](https://github.com/OXID-eSales/module-template/actions/workflows/trigger.yaml/badge.svg?branch=b-7.1.x)](https://github.com/OXID-eSales/module-template/actions/workflows/trigger.yaml)
[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/module-template?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/module-template)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/module-template)](https://github.com/oxid-esales/module-template)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)


Reusable module template for extending OXID eShop core functionality.

The module template contains examples for the most common use cases (see below)
like OXID suggests it could be implemented. 

This module also comes with all the quality tools OXID recommends to use.

## Table of contents
1. [Branch compatibility](#branch-compatibility)
2. [The Idea](#the-idea)
3. [Goals](#goals)
4. [Examples](#examples)
5. [Install and try it out](#install-and-try-it-out)
6. [Use as a base for own module](#use-as-a-base-for-own-module)
7. [Things to be aware of](#things-to-be-aware-of)
8. [Running tests and quality tools](#running-tests-and-quality-tools)
9. [Additional info](#additional-info)

## Branch compatibility

* b-7.3.x branch - compatible with OXID eShop compilation 7.3.x and the respective branch
* b-7.2.x branch / v4.x version - compatible with OXID eShop compilation 7.2.x and the respective branch
* b-7.1.x branch / v3.x version - compatible with OXID eShop compilation 7.1.x and the respective branch
* b-7.0.x branch / v2.x version - compatible with OXID eShop compilation b-7.0.x
* b-6.5.x branch / v1.0.0 version - compatible with OXID eShop compilation b-6.5.x
* b-6.4.x branch is compatible with OXID eShop compilation b-6.4.x 

## The Idea

OXID eSales would like to provide a lightweight reusable example module incorporating
our best practices recommendations to be used as a template for developing own module solutions.

Story:
- Module will extend a block on shop start page to show a greeting message (visible when module is active).
- Module will have a setting to switch between generic greeting message for a logged in user and a personal custom greeting. The Admin's choice which way it will be.
- A logged in user will be able to set a custom greeting depending on module setting. Press the button on start page and be redirected to a module controller which handles the input.
- User custom greetings are saved via shop model save method. We subscribe to BeforeModelUpdate to track how often a user changed his personal greeting.
- Tracking of this information will be done in a new database table to serve as an example for module's own shop model.
- Module will extend the shop's basket model to add info to module specific log file when an item is added into basket. Logging  can be enabled or disabled depending on module setting.
- Module will have console command `oetemplate:logger:read` to read log file.

```bash
./vendor/bin/oe-console oetemplate:logger:read
```

## Goals

There are three main goals this repository is intended to help with:

* Install and try out the module with simple examples to most common development questions.
* The provided solution can be used as a base for your own module. It will help creating
  the personalized module base with all the examples listed in the Examples section.
* The repository can be used for creating a clean skeleton with only preconfigured
  OXID recommended quality tools for your new module.

Please jump to the section that fits your needs.

## Examples

The repository contains examples of following cases and more:

* [Extending of shop controllers and models](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/metadata.php#L25)
  * extending a shop model (`OxidEsales\ModuleTemplate\Extension\Model\User`) / (`OxidEsales\ModuleTemplate\Extension\Model\Basket`)
  * extending a shop controller (`OxidEsales\ModuleTemplate\Extension\Controller\StartController`)

* [New controllers](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/metadata.php#L30)
  * own module controller (`oemtgreeting` with own template and own translations)
  * own module admin controller (`oemt_admin_greeting` with own template and own translations)

* [Using Symfony DI](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/services.yaml)
  * [Injection of Registry classes with bind](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/src/Greeting/services.yaml#L5)

* [Migrations](https://github.com/OXID-eSales/module-template/tree/b-7.2.x/migration)
  * extending a shop database table (`oxuser`)

* Accessing the database
  * model with a database (`OxidEsales\ModuleTemplate\Tracker\Model\GreetingTracker`)
  * ``oxNew`` object factory example (`OxidEsales\ModuleTemplate\Greeting\Infrastructure\UserModelFactory`)
  * [DAO](src/ProductVote/Dao)

* [Various types of module settings](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/metadata.php#L38)

* Templates
  * [creating templates for your module](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/views/twig/templates/greetingtemplate.html.twig)
  * [extending of oxid theme templates or blocks](https://github.com/OXID-eSales/module-template/tree/b-7.2.x/views/twig/extensions/themes)
    * extending a shop admin template block (`admin_user_main_form` - only an extension of a block, without functionality)
    * extending a shop template block (`start_newest_articles`)

* Using the translations for your module specific phrases
  * [in admin](https://github.com/OXID-eSales/module-template/tree/b-7.2.x/views/admin_twig)
  * [in frontend](https://github.com/OXID-eSales/module-template/tree/b-7.2.x/translations)

* Events and listeners
  * [Subscribing to shop events](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/src/Tracker/Subscriber/BeforeModelUpdate.php)

* Testing your module backend and frontend part
  * [Composer aliases for easy running of tests and quality tools](https://github.com/OXID-eSales/module-template/blob/b-7.2.x/composer.json#L48)
  * [Using the github actions as CI tool with all recommended tools preconfigured for you.](https://github.com/OXID-eSales/module-template/tree/b-7.2.x/.github)

**HINTS**:
* Only extend the shop core if there is no other way like listen and handle shop events,
  decorate/replace some DI service. 
* Your module might be one of many in the class chain and you should act accordingly (always ensure 
  to call the parent method and return the result). 
* When extending shop classes with additional methods, best prefix those methods in order to not end 
  up with another module picking the same method name and wreacking havoc.
* In case there is no other way than to extend existing shop methods try the minimal invasion principle.
  Put module business logic to a service (which make it easier to test as well) and call the service in the extended shop class.
  If you need to extend the shop class chain by overwriting, try to stick to the public methods.

#### Not yet in here but might come later:
* example for payment gateway extension
* seo url for module controller
* to redirect or not to redirect from inside the shop core
* graphql query/mutation example
* extending the internal part

## Install and try it out

Note: This installation method fits for trying out the module development basics,
its not meant to be used as development base for your own module. Check further
installation/usage methods.

This module is in working state and can be directly installed via composer:
```
composer require oxid-esales/module-template
./vendor/bin/oe-eshop-doctrine_migration migrations:migrate oe_moduletemplate
```

and [activate the module](https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/module/installation_setup/setup.html#setup-activation).

## Use as a base for own module

In case you'd like to use this module as a template for your own module, this section is for you.

**Important** Instructions here are for the case you intend to develop a module for OXID eShop 7.2.x. For other
versions, refer to the version specific branch.

Before starting to do something, please, read the whole section once, then decide on required questions, decide 
what you want to achieve, and follow the procedure.

### Terms

First, lets decide on terms:

* Module is installable to `vendor/<yourPackageName>` directory. The package name is **lowercased** and 
  looks like: `<yourVendorName>/<yourModuleName>`, example: `oxid-esales/module-template`. Decide 
  what will be your new module package name.
  * Please note that combination of `<yourVendorName>` and `<yourModuleRootDirectory>` should be unique. Based on this
    information your module id will be composed and will look like: `<yourVendorPrefix>_<yourModuleRootDirectory>`. In
    our case it is `oe_moduletemplate`.
  * It is recommended to use only alphanumeric characters, in case you need a separator you can use dash ("-") or underscore("_").
* Decide on your module's namespace - `<YourVendorName>\<YourModuleName>`, example: `OxidEsales\ModuleTemplate`.
* Decide on your module's ID - `<YourVendorPrefix>_<yourModuleName alphanumeric part>`, example: `oe_moduletemplate`.
  * It is recommended to use only alphanumeric characters, in case you need a separator you can use underscore. More 
    information about module id can be found [here](https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/module/skeleton/metadataphp/amodule/id.html).

In the following examples, your information required places will be shown as placeholders: `<yourPackageName>`, it means
you should put your package name at that place, without brackets, for example:

```
composer config repositories.<yourPackageName> path source/modules/<yourVendorName>/<yourModuleName>
```
will possibly look like:
```
composer config repositories.my-vendor-name/my-module-name path source/modules/mvn/mymodulerootdir
```
in our case it is:
```
composer config repositories.oxid-esales/module-template path source/modules/oe/module-template
```

### Procedure

The following procedure describes how to create a base for your further module, and shows the basic installation for the development process:

#### 1. Use the Template

Click on the "Use this template" button on the template [main page](https://github.com/OXID-eSales/module-template) to 
create your module repository from the given template. 

Please make sure to NOT choose the 'take all branches' option, as this will clone the repository with everything 
we have in our repository. Having all branches also will trigger the github actions for all branches and you dont want this usually. 

As an outcome of this step, you should have a repository with one "Initial commit" of our current latest repository state.

#### 2. Personalize and cleanup the module

To personalize the module, use the "bin/personalize.sh" script. This script will prompt you for required information and do the work.

To cleanup the module from all current examples and make it a clean skeleton, use the "bin/cleanexamples.sh" script. This script will remove all example solutions code.

Its not mandatory to cleanup the module from examples, but you have this option if you want to start from the clean skeleton.

For this step, clone your module repository anywhere to your local directory and run the desired scripts.

```bash
git clone <yourGitRepositoryUrl> myModule
cd myModule

// Run the personalize script
./bin/personalize.sh

// Run the clean examples script if you want to start from the clean skeleton
./bin/cleanexamples.sh

git commit -am "Personalize and cleanup the module"
git push origin
```

Please note that the module comes with a database table, translations, settings and some templates which still have the original
names after personalization, if cleanup was not done. Just keep an eye on all that's prefixed 'OEMT', 'oemt', 'OEMODULETEMPLATE' etc.

Also, you will need to adjust the README, CHANGELOG, LICENSE, metadata and the GitHub workflow file, with your
credentials and names. For running SonarCloud as part of the steps in GitHub workflow you
will need to configure SonarCloud and to create a secret environment variable for your repository called SONAR_TOKEN.
The token itself is provided by SonarCloud.

#### 3. Install the module for Development

For installing the module for development our recommended way, check the "Development installation section", 
or do it any other way you prefer, but make sure to reconfigure our preconfigured quality tools to fit your installation.

### Development installation

We recommend developing the module as independent as possible. This means that the module for development should
be installed as a root package, with its own strict dependencies if such are needed.

Consider using our docker based SDK and our ["Recipes"](https://github.com/OXID-eSales/docker-eshop-sdk-recipes) to 
install this module development variant. Make sure you have all your current docker containers stopped before starting on this.

```bash
cd ~/Projects
echo ModuleTemplate && git clone https://github.com/OXID-eSales/docker-eshop-sdk.git $_ && cd $_
git clone --recurse-submodules https://github.com/OXID-eSales/docker-eshop-sdk-recipes recipes/oxid-esales

// Important: In case you want to develop your module created from module template, edit the recipe with your 
// module repository and module id first

./recipes/oxid-esales/module-template/b-7.2.x-root.sh -eCE
```

## Things to be aware of

The module template is intended to act as a tutorial module so keep your eyes open for comments in the code.

**NOTES:** 
* Acceptance tests are way easier to write if you put an id on relevant fields and buttons in the templates. 
* If you can, try to develop on OXID eShop Enterprise Edition to get shop aware stuff right from the start.

### Module migrations

* migrations are intended to bump the database (and eventual existing data) to a new module version (this also goes for first time installation).
* ensure migrations are stable against rerun

Migrations have to be run via console command (`./vendor/bin/oe-eshop-doctrine_migration`)

```bash
./vendor/bin/oe-eshop-doctrine_migration migrations:migrate oe_moduletemplate
```

NOTE: Existing migrations must not be changed. If the database needs a change, add a new migration file and change to your needs:

```bash
./vendor/bin/oe-eshop-doctrine_migration migrations:generate oe_moduletemplate
```

For more information, check the [developer documentation](https://docs.oxid-esales.com/developer/en/latest/development/tell_me_about/migrations.html).


### Where the module namespace points to
As already mentioned above, in the 7.x versions of OXID eShop, the module code only resides in the vendor directory so the
namespace needs to point there. In our case this looks like

```bash
   "autoload": {
        "psr-4": {
            "OxidEsales\\ModuleTemplate\\": "src/",
            "OxidEsales\\ModuleTemplate\\Tests\\": "tests/"
        }
    },
```


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
- run `composer update` in module root directory

```bash
$ cd vendor/oxid-esales/module-template
$ composer update
```

After this done, check the "scripts" section of module `composer.json` file to see how we run tests.

```bash
$ composer tests-unit
$ composer tests-integration
$ composer tests-codeception
```

NOTE: From OXID eShop 7.0.x on database reset needs to be done with this command (please fill in your credentials)

```bash
$ bin/oe-console oe:database:reset --db-host=mysql --db-port=3306 --db-name=example --db-user=root --db-password=root --force
```

And just in case you need it, admin user can now also be created via commandline
```bash
$ bin/oe-console oe:admin:create-user --admin-email <admin-email> --admin-passowrd <admin-password>
```
for example
```bash
$ bin/oe-console oe:admin:create-user --admin-email admin@oxid-esales.com --admin-password admin
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

### Development Environment - Docker SDK

You can install the shop on whatever system fits your needs, but please check the 
[OXID Docker SDK recipes](https://github.com/OXID-eSales/docker-eshop-sdk-recipes).
That's what we use in OXID Development to quickly set up whatever development environment we need and
we are constantly trying to improve them.

### Github Actions Workflow

The module template comes complete with a github actions workflow. No need to rig up some separate continuous integration
infrastructure to run tests, it's all there in [github](https://github.com/OXID-eSales/module-template/actions).
You will see three files in `.github/workflow` directory. The workflow from
`.github/workflow/trigger.yaml` starts on every `push` and `pull_request` to run the code quality checks and all the module tests.

In our experience it is useful to run the shop tests with the module installed and activated from time to time.
For sure those shop tests have been written with only the shop itself in mind. Your module, depending on what it is doing, 
might completely change the shop behaviour. Which means those shop tests with a module might just explode in your face. 
Which is totally fine, as long as you can always explain WHY those tests are failing.

Real life example:  There is one shop acceptance test case `OxidEsales\EshopCommunity\Tests\Acceptance\Frontend\ShopSetUpTest:`
which is testing the frontend shop setup. Very good chance this test will fail if a module is around which extends 
the class chain. That test is for setting up a shop from scratch so it will simply not expect a module to be around.
And we only need our module to safely work with a working shop. We definitely will decide to skip that `ShopSetUpTest`
as we have a good explanation as to why it will not work. And having this special test case work with our module will give no benefit.

This is only one example, there might be other tests that fail with your module but fail because your module is changing the shop.
In that case the suggestion would be to exclude the original test from the github actions run, copy that test case to your module tests and
update to work with your module. This was for example the strategy used for our reverse proxy modules which are mandatory to not make the shop's 
acceptance tests fail. Unless those test cases that somehow bypass reverse proxy cache invalidation. To be on the safe side, we took over those 
few test cases to the module and plan to improve the shop tests as soon as possible. We'll gladly also take your PR with improved shop tests ;)

And then there are some few shop tests marked as `@group quarantine` in the doc block. Test in that group have stability issues so they'd better
be excluded as well.

Ps: a failing shop test might also turn up issues in your module, in that case fix the module and let the test live ;)

## Additional info

### Useful links

* Vendor home page - https://www.oxid-esales.com
* Bug tracker - https://bugs.oxid-esales.com
* Developer Documentation - https://docs.oxid-esales.com/developer/en/latest/
* Quality Tools and Requirements - https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/quality.html
* Docker SDK recipes - https://github.com/OXID-eSales/docker-eshop-sdk-recipes
* Docker SDK - https://github.com/OXID-eSales/docker-eshop-sdk

### Contact us

* In case of issues / bugs, use "Issues" section on github, to report the problem.
* [Join our community forum](https://forum.oxid-esales.com/)
* [Use the contact form](https://www.oxid-esales.com/en/contact/contact-us.html)

In case you have any complaints, suggestions, business cases you'd like an example for
please contact us. Pull request are also welcome.  Every feedback we get will help us improve.
