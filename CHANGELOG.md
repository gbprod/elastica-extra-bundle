# Change Log
All notable changes to this project will be documented in this file based on the [Keep a Changelog](http://keepachangelog.com/) Standard.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/gbprod/elastica-extra-bundle/compare/v0.2.0...HEAD)

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