<?php
  declare(strict_types=1);

  namespace Keyman\Site\Common;

  class KeymanSentry {
    static function init($dsn) {
      if(file_exists(__DIR__ . '/../tier.txt')) {
        // KeymanHosts::Instance()->Tier() doesn't exist at this point
        $tier = trim(file_get_contents(__DIR__ . '/../tier.txt'));
        $environment = strtolower(explode("_", $tier)[1]);
      } else if(isset($_SERVER['SERVER_NAME'])) {
        // running from web server
        $host = $_SERVER['SERVER_NAME'];
        if(preg_match('/\.localhost$/', $host))
          // If the host name is, e.g. api.keyman.com.local, then we'll assume this is a development environment
          $environment = 'development';
        else if(preg_match('/(^|\.)keyman-staging\.com$/', $host))
          $environment = 'staging';
        else
          $environment = 'production';
      } else if(isset($_ENV['WEBSITE_SITE_NAME'])) {
        // probably running from CLI in Azure (e.g. deployment or SCM)
        $host = $_ENV['WEBSITE_SITE_NAME'];
        $environment = preg_match('/staging/', $host) ? 'staging' : 'production';
      } else {
        // Unknown environment, probably local development CLI
        $environment = 'development';
      }

      \Sentry\init([
        'dsn' => $dsn,
        'environment' => $environment
      ]);
    }
  }