# Introduction

This Symfony Bundle propose a service to communicate with the [Pwinty](http://www.pwinty.com) API.

It uses the simple PHP implementation from [php-pwinty](https://github.com/Buendon/php-pwinty) and adds on top of it:
* An oriented-object API
* A Symfony service that can be used in a Symfony project.

# Installation

## Update your Symfony project composer.json

```
    "repositories" : [{
        "type": "vcs",
        "url": "https://github.com/Buendon/php-pwinty"
    }],
    ...
    "require": {
        ...
        "pwinty/php-pwinty" : "dev-api_2.3",
        "buendon/pwinty-bundle": "dev-master"
    },
    ...
```

Once done, run ```composer update```

Note that you need to declare a specific GitHub repository for the php-pwinty bundle.

Indeed, this one is a fork of [Pwinty/php-pwinty](https://github.com/Pwinty/php-pwinty).

I need to send a push request so that the original implementation is compatible withe the 2.3 version of the Pwinty API.

# Warning

This bundle still in construction, hence there is no official release yet.