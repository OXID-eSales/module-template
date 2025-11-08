# OXID eShop Module Template

[![Development](https://github.com/OXID-eSales/module-template/actions/workflows/trigger.yaml/badge.svg?branch=b-7.4.x)](https://github.com/OXID-eSales/module-template/actions/workflows/trigger.yaml)
[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/module-template?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/module-template)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/module-template)](https://github.com/oxid-esales/module-template)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_module-template&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_module-template)

Reusable module template for extending OXID eShop core functionality.

This module also comes with all the quality tools OXID recommends to use.

If you are looking for a module with code examples, please check out the [examples-module](https://github.com/OXID-eSales/examples-module).


## Table of contents
1. [Branch compatibility](#branch-compatibility)
2. [The Idea](#the-idea)
3. [Goals](#goals)
4. [Install and try it out](#install-and-try-it-out)
5. [Use as a base for own module](#use-as-a-base-for-own-module)
6. [Things to be aware of](#things-to-be-aware-of)
7. [Running tests and quality tools](#running-tests-and-quality-tools)
8. [Additional info](#additional-info)


## Branch compatibility

* b-7.4.x branch / v6.x version - compatible with OXID eShop compilation 7.4.x and the respective branch
* b-7.3.x branch / v5.x version - compatible with OXID eShop compilation 7.3.x and the respective branch
* b-7.2.x branch / v4.x version - compatible with OXID eShop compilation 7.2.x and the respective branch
* b-7.1.x branch / v3.x version - compatible with OXID eShop compilation 7.1.x and the respective branch
* b-7.0.x branch / v2.x version - compatible with OXID eShop compilation b-7.0.x
* b-6.5.x branch / v1.0.0 version - compatible with OXID eShop compilation b-6.5.x
* b-6.4.x branch is compatible with OXID eShop compilation b-6.4.x 


## The Idea

OXID eSales would like to provide a lightweight reusable module to be used as a template for developing own module solutions.


## Goals

The repository can be used for creating a clean skeleton with only preconfigured 
OXID recommended quality tools for your new module.


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

The following procedure describes how to create a base for your further module, and shows the basic installation for the development process.

**Important** Instructions here are for the case you intend to develop a module for OXID eShop 7.4.x. For other
versions, refer to the version specific branch.

**Please note there are different approaches presented, so before the start, please, read the whole section once, decide 
what you want to achieve, and follow the selected process.** 

**In case there are multiple ways given, please select the One you prefer, do not mix them together unless you 
fully understand what you are doing.**

### Terms

First, lets decide on terms:

* Live module is installable to `vendor/<yourPackageName>` directory. The package name is **lowercased** and
  looks like: `<yourVendorName>/<yourModuleName>`, example: `oxid-esales/module-template`. Decide
  what will be your new module package name.
    * Please note that combination of `<yourVendorName>` and `<yourModuleRootDirectory>` should be unique.
    * It is recommended to use only alphanumeric characters, in case you need a separator you can use the dash ("-") or the underscore("_").
* Decide on your module's namespace - `<YourVendorName>\<YourModuleName>`, example: `OxidEsales\ModuleTemplate`.
* Decide on your module's ID - `<YourVendorPrefix>_<yourModuleName alphanumeric part>`, example: `oe_moduletemplate`.
    * It is recommended to use only alphanumeric characters, in case you need a separator you can use underscore. More
      information about module id can be found [here](https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/module/skeleton/metadataphp/amodule/id.html).

### 1. Use the Template

In all the cases, first of all, you want to have your module in your own repository, so Click on the 
"Use this template" button on the template [main page](https://github.com/OXID-eSales/module-template) to 
create your module repository from the given template. 

Please make sure to NOT choose the 'take all branches' option, as this will clone the repository with everything 
we have in our repository. Having all branches also will trigger the github actions for all branches and you dont want this usually. 

As an outcome of this step, you should have a repository with one "Initial commit" of our current latest repository state.

### 2a. Use the OXID SDK for your new module development

This section shows our recommended way to go with OXID module development, by using the [OXID SDK](https://github.com/OXID-eSales/docker-eshop-sdk) and recommended 
development structure. Make sure your system meets the requirements of the SDK.

We recommend developing the module as independent as possible. This means that the module for development should
be installed as a [root package](https://getcomposer.org/doc/04-schema.md#root-package), with its own strict dependencies if such are needed.

#### 0. Ensure all docker containers are down to avoid port conflicts!

#### 1. Clone the SDK for the new project

    echo MyProject && git clone https://github.com/OXID-eSales/docker-eshop-sdk.git $_ && cd $_

#### 2. Clone your new module repository

Clone the repository which you just created with using the template button to the SDK source directory.
**Please make sure you replace the github repository url to your own in the command!**

    git clone --recurse-submodules https://github.com/OXID-eSales/module-template.git --branch=b-7.4.x ./source

#### 3a. Personalize the module 

This can be done in two ways. Check 3a. if you are the user of Claude.ai and 3b. in case you want to do it by hand.

3a. Navigate to source, run claude and ask to help

    cd ./source
    claude
    personalize
   
3b. If you dont use Claude to help you with the personalization, you can do it yourself with running the personalization 
script directly:

    ./source/bin/personalize.sh
   
Afterwards, Search for the "TODO" keywords in the code and replace them with your information

#### 4. Start the development environment

This can be done with the `./source/recipes/setup-development.sh` script.

First, check the contents of it and ensure all the versions (branches) described there are as you expect.
Run the recipe to setup the development environment(you can decide which shop edition to install. Omitting the flag installs EE):

    ./source/recipes/setup-development.sh -e CE

When this was done, you should be able to access the shop with http://localhost.local and the admin panel with http://localhost.local/admin
(credentials: noreply@oxid-esales.com / admin)

### 2b. Personalize and cleanup the module without the OXID SDK installation

This section shows the case when you dont want to go with the OXID SDK or our recommended way, but still want to use the template.

You still have the possibility to personalize the module through the use of the "bin/personalize.sh" script. This script will 
prompt you for required information and do the work.

Clone your module repository anywhere to your local directory, run the personalization script and push the personalized 
module to your repository.

    // Clone your module repository anywhere
    git clone <yourGitRepositoryUrl> myModule
    cd myModule
    
    // Run the personalize script
    ./bin/personalize.sh
    
    // Search for the "TODO" keywords in the code and replace them with your information
    
    // Commit and push your personalized module, after this, install it for development and continue from there 
    git commit -am "Personalize the module"
    git push origin

After personalization, make sure to reconfigure our preconfigured quality tools to fit your directory structure and
your prefered way of development.

### 3. Final steps before you start on your module special logic

Remember to adjust the README, CHANGELOG, LICENSE, metadata and the GitHub workflow file, with your
credentials and names. For running SonarCloud as part of the steps in GitHub workflow you
will need to configure SonarCloud and to create a secret environment variable for your repository called SONAR_TOKEN.
The token itself is provided by SonarCloud.


## Things to be aware of

The module template is intended to act as a skeleton module so keep your eyes open for comments in the code.

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

For more information, check the [developer documentation](https://docs.oxid-esales.com/developer/en/latest/development/tell_me_about/migrations.html).


### Where the module namespace points to
As already mentioned above, in the 7.x versions of OXID eShop, the module code only resides in the vendor directory so the
namespace needs to point there. In our case this looks like

```bash
    "autoload": {
        "psr-4": {
            "OxidEsales\\ModuleTemplate\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "OxidEsales\\ModuleTemplate\\Tests\\": "tests/",
            "OxidEsales\\EshopCommunity\\Tests\\": "./vendor/oxid-esales/oxideshop-ce/tests"
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
frontend. If the module breaks the frontend, we need to see it asap.

The great thing about codeception tests is - they can create screenshot and html
output in failure case, so you literally get a picture of the fail (`tests/Coreception/_output/`).

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

* Module with useful code examples - https://github.com/OXID-eSales/examples-module
* Vendor home page - https://www.oxid-esales.com
* Bug tracker - https://bugs.oxid-esales.com
* Developer Documentation - https://docs.oxid-esales.com/developer/en/latest/
* Quality Tools and Requirements - https://docs.oxid-esales.com/developer/en/latest/development/modules_components_themes/quality.html
* Docker SDK - https://github.com/OXID-eSales/docker-eshop-sdk

### Contact us

* In case of issues / bugs, use "Issues" section on github, to report the problem.
* [Join our community forum](https://forum.oxid-esales.com/)
* [Use the contact form](https://www.oxid-esales.com/en/contact/contact-us.html)

In case you have any complaints, suggestions, business cases you'd like an example for
please contact us. Pull request are also welcome.  Every feedback we get will help us improve.
