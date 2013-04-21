README
======

What is Vehicle-Fits?
---------------------
Vehicle Fits is an extension to add automotive features to your Magento shopping cart. We install either shopping cart for you, as well as install the Vehicle Fits extension itself. Once your shopping cart has the Vehicle Fits extension installed, you will have hundreds of automotive features including a year/make/model search.
The year/make/model search can be customized in 50+ ways, including the ability to change the number, order, or names of the select box. For example if you want to add a select box called "engine", or remove the select box called "year" you can do so. You can have as few as two select boxes, or as many as you'd like.
You can import your existing data, or use Vehicle Fits to create your own data using our vehicle databases.

Installation Instructions
-------------------------
 * Install [Vehicle-Fits-Core](https://github.com/vehiclefits/Vehicle-Fits-Core) to `lib/VF` in the Magento root.
 * Install the following repository by dropping in the Magento root.

Run Unit Tests
--------------------------------
If you're interested in running the unit tests that come with Vehicle Fits, simply download [Composer](http://getcomposer.org/download/) and do the following:

```
cd app/code/local/Elite
composer install --dev
```

After you've installed composer, you may need to rename the `phpunit.xml.dist` to `phpunit.xml` and change the following configuration's to your specifications:
```xml
<php>
    <env name="PHP_MAGE_PATH" value="/home/josh/www/magento"/>
    <env name="PHP_TESTFILES" value="/tmp"/>
    <env name="PHP_VAF_DB_USERNAME" value="root"/>
    <env name="PHP_VAF_DB_PASSWORD" value=""/>
    <env name="PHP_VAF_DB_NAME" value="magento"/>
</php>
```

After you've installed composer, and changed the `phpunit.xml` if needed, you may run one of the following commands:

`phpunit` to run all the unit tests for the Magento module and Core tests.

`phpunit vendor/bin/phpunit --testsuite "VF Magento Test Suite"` to run just the Magento module tests.

`phpunit vendor/bin/phpunit --testsuite "VF Core Test Suite"` to run the lib/VF tests.

Documentation
-------------
Vehicle Fits' documentation is accessible at our website at: [http://vehiclefits.com/documentation/](http://vehiclefits.com/documentation/)

Contributing
------------
Vehicle Fits is an open source, community-driven project. If you'd like to contribute, please contact [sales@vehiclefits.com](mailto:sales@vehiclefits.com) for guidelines on how to contribute.

License
-------
Every commit in this repository is licensed under OSL-3.0 see VF_LICENSE.txt