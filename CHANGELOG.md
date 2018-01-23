# Change Log
All notable changes to this project will be documented in this file based on the [Keep a Changelog](http://keepachangelog.com/) Standard.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/gbprod/elastica-extra-bundle/compare/v1.1.0...HEAD)

## [1.1.0](https://github.com/gbprod/elastica-extra-bundle/compare/v1.0.0...1.1.0)

- Upgrade to elastica 6.0
- Add Symfony 4.0 support
- fix: listing indices without indices was throwing an error

## [1.0.0](https://github.com/gbprod/elastica-extra-bundle/compare/v0.3.0...v1.0.0)

### Changed

- Upgrade to elastica 5.0
- Drop Elastica 3.1 support
- Drop Symfony 2.3 support

### Added 

- Contributing file
- Reindex command

## [0.4.0](https://github.com/gbprod/elastica-extra-bundle/compare/v0.3.0...v0.4.0)

### Removed

- composer.lock is not in sources anymore

### Added

 - VersionEye badge
 - Scrutinizer checks PSR2 codestyle
 - You can now specify an alias to use a different configuration when running `create` `put_settings` `put_mappings` commands
 - Add list index command

## [0.3.0](https://github.com/gbprod/elastica-extra-bundle/compare/v0.2.0...v0.3.0)

### Changed

- Upgrade to elastica 3.2
- Use codecov for coverage instead of scrutinizer
- Delete not existing index will not throw exception anymore (replace by a info message)

## [0.2.0](https://github.com/gbprod/elastica-extra-bundle/compare/v0.1.0...v0.2.0)

### Added
- `elasticsearch:alias:list` command
- `elasticsearch:alias:add` command
- `elasticsearch:alias:remove` command
- Changelog

## 0.1.0 - 2016-04-17

### Added
- `elasticsearch:index:create` command
- `elasticsearch:index:delete` command
- `elasticsearch:index:put_settings` command
- `elasticsearch:index:put_mappings` command
- indices mapping and ssettings configuration
- default client setup
