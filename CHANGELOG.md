# Change Log for OXID eShop Module Template

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.1] - Unreleased

### Fixed
- Cleanup module activation/deactivation from tests, use OxideshopModules codeception module

## [2.0.0] - 2023-06-02

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

## [1.0.0] - 2023-03-03

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

## [1.0.0-rc.1] - 2022-05-05

### Added
- First version of our reusable examples

[2.0.0]: https://github.com/OXID-eSales/module-template/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/OXID-eSales/module-template/compare/v1.0.0-rc.1...v1.0.0
[1.0.0-rc.1]: https://github.com/OXID-eSales/module-template/compare/d1380c5a9c63f411011ab852bd25b66e83306b41...v1.0.0-rc.1