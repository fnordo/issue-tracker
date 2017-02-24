# Acme Issue Tracker

A tiny example application built with symfony2.

### Requirements

* composer
* sqlite3
* PHP >= 5.4


### Run the application
* Download and extract project .zip
* `cd` into the projects root directory
* [Get composer](https://getcomposer.org/)
* Install the vendors (when asked for parameters, just go with the default values and you should be fine):

```
./composer.phar install
```

* Make sure the setup script (located in `bin/init.sh`) is executable and run it (this will initialize the app and start the development server):

```
chmod u+x bin/init.sh
bin/init.sh

```

* Access the frontend under `http://127.0.0.1:8000` resp. `http://localhost:8000`