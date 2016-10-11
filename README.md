Activity Stream Bundle
======================

About
---------------

@WIP

Activity Stream Bundle is a PHP 5.6+ Symfony bundle providing a stream activity log management.

Installation
------------

### With composer

This bundle can be installed using [composer](http://getcomposer.org) by adding the following in the `require` section of your `composer.json` file:

``` json
    "require": {
        ...
        "sipsynergy/activity-stream-bundle": "1.0.0"
    },
```

### Register the bundle

You must register the bundle in your kernel:

``` php
<?php

// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(

        // ...

        new Sipsynergy\ActivityStreamBundle\SipsynergyActivityStreamBundle(),
    );

    // ...
}
```

## Run migrations.

Either using ```doctrine:migrations:migrate``` or ```doctrine:schema:update```

Configuration
-------------

### Configuring 

If you wish to use your own default renderer, define it and point bundle to it.

``` yaml
# app/config/config.yml
sipsynergy_activity_stream:
    renderer:
        default_class: YourRendererClass
```


### Defining renderer services

In order to create new render service just provide definition for it with appropriate tag.

```xml
<service id="activity_stream.renderer_custom" class="%activity_stream.renderer_custom.class%">
    <argument type="service" id="router"/>
    <tag name="activity_stream.renderer"/>
</service>
```
