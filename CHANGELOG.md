# Change Log for OXID eShop Module Template

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v3.2.0] - Unreleased

### Removed
- PHP 8.1 support removed

## [v3.1.0] - unreleased

### Added
- Admin controller example in Greeting namespace
- Template for special greeting admin controller
- Example with extending of current admin template
- ``oxNew`` model object factory example in Greeting namespace infrastructure

### Fixed
- "the input device is not a TTY" error message during github hook if problems found

## [v3.0.0] - 2024-06-27

This is the stable release for v3.0.0. No changes have been made since v3.0.0-rc.1.

## [v3.0.0-rc.1] - 2024-05-30

### Added
- All quality and testing tools are now running from module directory. Run `composer update` in module root directory and check "scripts" section in `composer.json` 
- The BeforeModelUpdate event handler test.
- Coverage pointers to tests, so we could see more precisely, what we have tested and what was covered unintensionnally
- Interfaces extracted and used where possible

### Changed
- Github workflow examples updated to use our new reusable workflow. Its possible for anyone to easily run quality tools and tests on this example now with minimal effort.
- All classes have been splitted by domains: Greeting/Logging/Settings/Tracker. Also there is Extension directory for shop extending classes.
- Pre-commit hook example to run our static analysis tools before commit.
- PhpUnit updated to 10+

### Removed
- `ServiceContainer` trait and its usage
- Example with static access rule exclusion. Now, the standard case have an example with exclusion of Symfony Filesystem\Path component.
- PHP 8.0 support removed
- Smarty support
- Migration are not triggered anymore on module activation. Ensure you run them separately after module **Installation**.

## [v2.2.0] - unreleased

### Added
- Admin controller
- Template for admin controller
- Example of extending of current admin template
- ``oxNew`` object factory example

## [v2.1.0] - 2024-05-30

### Added
- New example service to extend basket class and logs it 
- An example command to read logs from file
- Improve test coverage

### Fixed
- Cleanup module activation/deactivation from tests, use OxideshopModules codeception module
- Specify reports location for static analyzers. Fix missing phpmd reports to be available

### Changed
- Change license from GNU GPL to oxid module and component license

## [v2.0.0] - 2023-06-02

### Added
- Improved the phpmd configuration [PR-10](https://github.com/OXID-eSales/module-template/pull/10)
- Workflow jobs can be rerun separately after failures

### Changed
- Updated module to work with shop 7
- Update to work with APEX theme by default

### Fixed
- Improved cache keys in workflow to be more precise
- Do not use shop class names in services to avoid possible breaking overwrites
- Optimize selenium container usage in workflow
- Example shop tests with module workflow fixed

### Removed
- Older "Twig" theme support

## [v1.0.0] - 2023-03-03

### Added
- More examples with possible configuration settings for module
- More precise dependency on the shop versions added
- Missing translations in module settings
- Dependabot configured in repository to check for dependency issues
- Separate manual workflow for generating coverage artifacts
- Quality badges example in readme

### Changed
- Update phpstan version

### Fixed
- Migrations executed on module activation only if new, not executed ones present
- Cleanup not used dev dependencies
- Test run failures on https configuration; Enable not secure dev certificates in tests
- Failed tests in the workflow will mark workflow red, not green anymore
- Consistent abbreviation: OEMT

## [v1.0.0-rc.1] - 2022-05-05

### Added
- First version of our reusable examples
