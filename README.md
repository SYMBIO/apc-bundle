Provide a command line to clear APC/APCu cache from the console.

The problem with APC/APCu is that it's impossible to clear it from command line.
Because even if you enable APC/APCu for PHP CLI, it's a different instance than,
say, your Apache PHP or PHP-CGI APC/APCu instance.

The trick here is to create a file in the web dir, execute it through HTTP,
then remove it.

Installation
============

  1. Add it to your composer.json:

      ```json
      {
          "require": {
              "symbio/apc-bundle": "dev-master"
          }
      }
      ```

     or:

      ```sh
          composer require symbio/apc-bundle:dev-master
          composer update symbio/apc-bundle:dev-master
      ```

  2. Add this bundle to your application kernel:

          // app/AppKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Symbio\ApcBundle\SymbioApcBundle(),
                  // ...
              );
          }

  3. Configure `symbio_apc` service:

          # app/config/config.yml
          symbio_apc:
              base_url:   http://localhost/ # could also be https://, or http://127.0.0.1:8000/, or any other valid URL
              web_dir:    %kernel.root_dir%/../web

  4. Set Apache user write permissions to web_dir

          $ chmod 775 web

Usage
=====

Clear all APC/APCu cache:

      $ php app/console symbio:apc:clear
      $ php app/console symbio:apcu:clear


Capifony usage
==============

To automatically clear APC/APCu cache after each capifony deploy you can define a custom task

```ruby
namespace :symfony do
  desc "Clear APC/APCu cache"
  task :clear_apc do
    capifony_pretty_print "--> Clear APC cache"
    run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} symbio:apc:clear --env=#{symfony_env_prod}'"
    capifony_puts_ok
  end
end
```

and add this hook

```ruby
# apc
after "deploy", "symfony:clear_apc"
```

Nginx configuration
===================

If you are using nginx and limiting PHP scripts that you are passing to fpm you need to allow 'APC/APCu' prefixed php files. Otherwise your web server will return the requested PHP file as text and the system won't be able to clear the APC/APCu cache.

Example configuration:
```
# Your virtual host
server {
  ...
  location ~ ^/(app|app_dev|apcu?-.*)\.php(/|$) { { # This will allow APC/APCu (apc-{MD5HASH}.php) files to be processed by fpm
    fastcgi_pass                127.0.0.1:9000;
    ...
```