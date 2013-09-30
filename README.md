[![Build Status](https://api.travis-ci.org/vehiclefits/vfmagento.png)](https://travis-ci.org/vehiclefits/vfmagento)

Development Only
---------------------
The source code here is for development only. If you are an end user, the only supported installation method is to grab the stable downloads here - http://vehiclefits.com/download

What is Vehicle-Fits?
---------------------
Vehicle Fits is an extension to add automotive features to your Magento or Prestashop shopping cart. We install either shopping cart for you, as well as install the Vehicle Fits extension itself. Once your shopping cart has the Vehicle Fits extension installed, you will have hundreds of automotive features including a year/make/model search.
The year/make/model search can be customized in 50+ ways, including the ability to change the number, order, or names of the select box. For example if you want to add a select box called "engine", or remove the select box called "year" you can do so. You can have as few as two select boxes, or as many as you'd like.
You can import your existing data, or use Vehicle Fits to create your own data using our vehicle databases.

Upgrade Instructions
--------------------
If you are running v1.35 or less, you *must* export your current fitments to CSV or XML before installing this version.

Installation Instructions using [modman](https://github.com/colinmollenhour/modman) and [Composer](http://getcomposer.org/download/)
--------------------------
This is the recommended installation procedure due to the fact that we use the composer autoloader to load the Vehicle Fits Core library into the magento module

```
$ cd /path/to/root/magento/install
$ modman clone https://github.com/vehiclefits/Vehicle-Fits-Magento
$ cd .modman/Vehicle-Fits-Magento/app/code/local/Elite
$ composer install
```

After installation, log into Magento's admin panel and go to system -> configuration -> developer -> template settings -> Allow Symlinks: *Yes*

Creating Your Schema For Your Fitments
-----------------------
This step is assuming that you already followed the installation instructions above to have a working installation.

```
$ cd /path/to/root/magento/install/
$ cd app/code/local/Elite
$ php bin/vfmagento schema
```

After you typed into the schema creation tool you will be given instructions on how to proceed.

Troubleshooting
-------------------------
 * Flush Magento Cache Storage.
 * Disable Magento 'compilation module' (a form of cache)
 * Run SQL in phpMyAdmin `SET @@global.sql_mode= ”;` to disable Strict Mode in mySQL. [todo - fix queries such that this step is not needed [#44](https://github.com/vehiclefits/Vehicle-Fits-Magento/issues/44)]

Run Unit Tests
--------------------------------
If you're interested in running the unit tests that come with Vehicle Fits, simply download [Composer](http://getcomposer.org/download/) and do the following:

```
$ cd app/code/local/Elite
$ composer install --dev
```

After you've installed composer, you may need to rename the `phpunit.xml.dist` to `phpunit.xml` and change the following configuration's to your specifications:
```xml
<php>
    <env name="PHP_MAGE_PATH" value="/home/josh/www/magento"/>
    <env name="PHP_TEMP_PATH" value="/tmp"/>
    <env name="PHP_VAF_DB_USERNAME" value="root"/>
    <env name="PHP_VAF_DB_PASSWORD" value=""/>
    <env name="PHP_VAF_DB_NAME" value="magento"/>
</php>
```

After you've installed composer, and changed the `phpunit.xml` if needed, you may run the following command:

````
#run all the unit tests for the Magento module
vendor/bin/phpunit
````

Documentation
-------------
Vehicle Fits' documentation is accessible at our website at: [http://vehiclefits.com/vf-documentation/index.htm](http://vehiclefits.com/vf-documentation/index.htm)

Contributing
------------
Vehicle Fits is an open source, community-driven project. If you'd like to contribute, please contact [sales@vehiclefits.com](mailto:sales@vehiclefits.com) for guidelines on how to contribute.

License
-------
Every commit in this repository is licensed under OSL-3.0 see VF_LICENSE.txt
