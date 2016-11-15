# ElasticaExtraBundle

[![Build Status](https://travis-ci.org/gbprod/elastica-extra-bundle.svg?branch=master)](https://travis-ci.org/gbprod/elastica-extra-bundle)
[![codecov](https://codecov.io/gh/gbprod/elastica-extra-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/gbprod/elastica-extra-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/elastica-extra-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/elastica-extra-bundle/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/574a9ca2ce8d0e004505fa46/badge.svg)](https://www.versioneye.com/user/projects/574a9ca2ce8d0e004505fa46)

[![Latest Stable Version](https://poser.pugx.org/gbprod/elastica-extra-bundle/v/stable)](https://packagist.org/packages/gbprod/elastica-extra-bundle)
[![Total Downloads](https://poser.pugx.org/gbprod/elastica-extra-bundle/downloads)](https://packagist.org/packages/gbprod/elastica-extra-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gbprod/elastica-extra-bundle/v/unstable)](https://packagist.org/packages/gbprod/elastica-extra-bundle)
[![License](https://poser.pugx.org/gbprod/elastica-extra-bundle/license)](https://packagist.org/packages/gbprod/elastica-extra-bundle)

Bundle providing extra elastica tools for managing indices and types settings.

## Installation

With composer :

```bash
composer require gbprod/elastica-extra-bundle
```

Update your `app/AppKernel.php` file:

```php
public function registerBundles()
{
    $bundles = array(
        new GBProd\ElasticaExtraBundle\ElasticaExtraBundle(),
    );
}
```

## Configure Elastica client

```yml
gbprod_elastica_extra:
    default_client: 'elastica.default_client' # Elastica client service's name
```

You can create Elastica client using a bundle like:
  * [FOSElasticaBundle](https://github.com/FriendsOfSymfony/FOSElasticaBundle)
    Service name will look like `fos_elastica.client.my_client`
  * My lightweight bundle [ElasticaBundle](https://github.com/gbprod/elastica-bundle)
    Service name will look like `elastica.default_client`
  * DIY


## Index Management Operations

### Configuration

Set indices setup

```yaml
elastica_extra:
    default_client: 'elastica.default_client'
    indices:
        my_index:
            settings:
                number_of_shards: 3
                number_of_replicas: 2
            mappings:
                my_type:
                    _source:
                        enabled: true
                    properties:
                        first_name:
                            type: string
                            analyzer: standard
                        age:
                            type: integer
        my_index_2: ~
```

### Create index

Will create index using his configuration.

```bash
php app/console elasticsearch:index:create my_index
```

Will create index using another index configuration (usefull when using aliases)

```bash
php app/console elasticsearch:index:create my_versionned_index --alias=my_index
```

### Delete index

```bash
php app/console elasticsearch:index:delete my_index --force
```

### Put index settings

```bash
php app/console elasticsearch:index:put_settings my_index
```

Will put index settings using another index configuration (usefull when using aliases)

```bash
php app/console elasticsearch:index:put_settings my_versionned_index --alias=my_index
```

### Put index mappings

```bash
php app/console elasticsearch:index:put_mappings my_index my_type
```

Will put index mappings using another index configuration (usefull when using aliases)

```bash
php app/console elasticsearch:index:put_mappings my_versionned_index my_type --alias=my_index
```

## Aliases Management Operations

### List aliases for an index

```bash
php app/console elasticsearch:alias:list my_index
```

### Add alias for an index

```bash
php app/console elasticsearch:alias:add my_index my_alias
```

If `--replace` options is set, an existing alias will be replaced

```bash
php app/console elasticsearch:alias:add my_index my_alias --replace
```

### Remove alias for an index

```bash
php app/console elasticsearch:alias:remove my_index my_alias
```

### List indices

This command list indices

```bash
php app/console elasticsearch:index:list
```

You also can filter displayed indices using regex

```bash
php app/console elasticsearch:index:list --pattern="user*"
```

### Use a different client

For all commands you can specify a different client using `--client` option.

eg:

```bash
php app/console elasticsearch:index:create my_index --client=my_client_service
```
