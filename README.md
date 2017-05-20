# Introduction

This Symfony Bundle propose a service to communicate with the [Pwinty](http://www.pwinty.com) API.

It uses the simple PHP implementation from [php-pwinty](https://github.com/Buendon/php-pwinty) and adds on top of it:
* An oriented-object API
* A Symfony service that can be used in a Symfony project.

# Installation

## Update your Symfony project composer.json

```
    ...
    "require": {
        ...
        "buendon/pwinty-bundle": "1.0-dev"
    },
    ...
```

Once done, run ```composer update```