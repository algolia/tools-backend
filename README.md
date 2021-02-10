This repo contains the backend of https://github.com/algolia/tools.

> :warning: While being functional/stable and used daily, these tools are not part of the Algolia product offering and need to be used with caution. We highly encourage to use them only on non-production data

## List of Features

This repo is a laravel application that allows to run the following feature:
- Algolia Oauth proxy (not public yet, so can only be used by algolia employees)
- State management for [metaparams](https://github.com/algolia/tools/)
- Tests management for [relevance testing](https://github.com/algolia/tools/)

## Install

Install dependencies:

```
composer install
```

Create database table:

```
php artisan migrate
```

## Run

To run locally the recommended way is to use [Valet](https://laravel.com/docs/8.x/valet) that will take care of serving the laravel app and providing a local domain.

## Getting Help

For any question/issue/proposal, you can open a github issue
**Need help?** You can open a GitHub issue.

## Getting involved

If you **want to contribute** please feel free to **submit pull requests**.
If you have **a feature request** please **open an issue**.

## Licence

InstantSearch iOS is [Apache 2.0 licensed](LICENSE.md)
