# Sauls Collections

[![Build Status](https://travis-ci.org/sauls/collections.svg?branch=master)](https://travis-ci.org/sauls/collections)
[![Packagist](https://img.shields.io/packagist/v/sauls/collections.svg)](https://packagist.org/packages/sauls/collections)
[![Total Downloads](https://img.shields.io/packagist/dt/sauls/collections.svg)](https://packagist.org/packages/sauls/collections)
[![Coverage Status](https://img.shields.io/coveralls/github/sauls/collections.svg)](https://coveralls.io/github/sauls/collections?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sauls/collections/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sauls/collections/?branch=master)
[![License](https://img.shields.io/github/license/sauls/collections.svg)](https://packagist.org/packages/sauls/collections)

Various collections to store and retrieve your data.

## Requirements

PHP >= 7.2

## Installation

### Using composer
```bash
$ composer require sauls/collections
```

### Apppend the composer.json file manually
```json
{
    "require": {
        "sauls/collections": "^1.0"
    }
}
```

## Documentation

### Available collections

* ArrayCollection
* ImmutableArrayCollection

### Additional type converters to [sauls/helpers](https://github.com/sauls/helpers) `function convert_to`

* CollectionToArrayConverter
* ArrayableToArrayConverter
