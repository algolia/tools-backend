This repo contains the backend of https://github.com/algolia/tools.

> :warning: While being functional/stable and used daily, these tools are not part of the Algolia product offering and need to be used with caution. We highly encourage to use them only on non-production data

## List of Features

This repo is a laravel application that allows to run the following feature:
- Algolia Oauth proxy (not public yet, so can only be used by algolia employees)
- State management for [metaparams](https://github.com/algolia/tools/)
- Tests management for [relevance testing](https://github.com/algolia/tools/)

## Install

Install dependencies

Note that version 7.1 is required, which is a legacy version of PHP. These instructions are specific to
MacOS. For other operating systems, please refer to their individual documentation for the relevant tools.

```sh
brew install shivammathur/php/php@7.1
```

Make sure to add php 7.1 to your path

```sh
echo 'export PATH="/opt/homebrew/opt/php@7.1/bin:$PATH"' >> ~/.zshrc
echo 'export PATH="/opt/homebrew/opt/php@7.1/sbin:$PATH"' >> ~/.zshrc
echo 'export LDFLAGS="-L/opt/homebrew/opt/php@7.1/lib"' >> ~/.zshrc
echo 'export CPPFLAGS="-I/opt/homebrew/opt/php@7.1/include"' >> ~/.zshrc
```

[composer](https://getcomposer.org/download/)

```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"                                                                             ✘ INT
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Make sure to move composer to a directory in your PATH

```sh
mv composer.phar /usr/local/bin/composer
```

And then to get the dependencies:

```sh
composer update
composer install
```

Create database table:

```
php artisan migrate
```

## Run

To run locally the recommended way is to use [Valet](https://laravel.com/docs/8.x/valet) that will take care of serving the laravel app and providing a local domain.

```sh
composer global require laravel/valet:^2.1
echo 'export PATH="~/.composer/vendor/bin:$PATH"' >> ~/.zshrc

valet use php@7.1
valet install
```

## Getting Help

For any question/issue/proposal, you can open a github issue
**Need help?** You can open a GitHub issue.

## Getting involved

If you **want to contribute** please feel free to **submit pull requests**.
If you have **a feature request** please **open an issue**.

## Licence

InstantSearch iOS is [Apache 2.0 licensed](LICENSE.md)
