# Change Log for OXID eShop Module Template

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.0.0] - Unreleased

### Added
- More examples with possible configuration settings for module
- More precise dependency on the shop versions added
- Missing translations in module settings
- Dependabot configured in repository to check for dependency issues
- Separate manual workflow for generating coverage artifacts
- Quality badges example in readme

### Fixed
- Migrations executed on module activation only if new, not executed ones present
- Cleanup not used dev dependencies
- Test run failures on https configuration; Enable not secure dev certificates in tests
- Failed tests in the workflow will mark workflow red, not green anymore

## [1.0.0-rc.1] - 2022-05-05

### Added
- First version of our reusable examples

[1.0.0]: https://github.com/OXID-eSales/module-template/compare/v1.0.0-rc.1...b-6.5.x
[1.0.0-rc.1]: https://github.com/OXID-eSales/module-template/compare/d1380c5a9c63f411011ab852bd25b66e83306b41...v1.0.0-rc.1