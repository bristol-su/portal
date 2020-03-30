<?php return array (
  'beyondcode/laravel-dump-server' => 
  array (
    'providers' => 
    array (
      0 => 'BeyondCode\\DumpServer\\DumpServerServiceProvider',
    ),
  ),
  'bristol-su/assign-roles' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Module\\AssignRoles\\ModuleServiceProvider',
    ),
  ),
  'bristol-su/control' => 
  array (
    'dont-discover' => 
    array (
    ),
    'providers' => 
    array (
      0 => 'BristolSU\\ControlDB\\ControlDBServiceProvider',
    ),
  ),
  'bristol-su/static-page' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Module\\StaticPage\\ModuleServiceProvider',
    ),
  ),
  'bristol-su/support' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Support\\SupportServiceProvider',
    ),
    'dont-discover' => 
    array (
      0 => 'laravel/passport',
      1 => 'venturecraft/revisionable',
    ),
  ),
  'bristol-su/typeform' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Module\\Typeform\\ModuleServiceProvider',
    ),
  ),
  'bristol-su/typeform-service' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Service\\Typeform\\TypeformServiceProvider',
    ),
  ),
  'bristol-su/unioncloud-portal' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\UnionCloud\\UnionCloudIntegrationServiceProvider',
    ),
  ),
  'bristol-su/upload-file' => 
  array (
    'providers' => 
    array (
      0 => 'BristolSU\\Module\\UploadFile\\ModuleServiceProvider',
    ),
  ),
  'fideloper/proxy' => 
  array (
    'providers' => 
    array (
      0 => 'Fideloper\\Proxy\\TrustedProxyServiceProvider',
    ),
  ),
  'fruitcake/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'itsgoingd/clockwork' => 
  array (
    'providers' => 
    array (
      0 => 'Clockwork\\Support\\Laravel\\ClockworkServiceProvider',
    ),
    'aliases' => 
    array (
      'Clockwork' => 'Clockwork\\Support\\Laravel\\Facade',
    ),
  ),
  'laracasts/utilities' => 
  array (
    'providers' => 
    array (
      0 => 'Laracasts\\Utilities\\JavaScript\\JavaScriptServiceProvider',
    ),
    'aliases' => 
    array (
      'JavaScript' => 'Laracasts\\Utilities\\JavaScript\\JavaScriptFacade',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravel/vapor-core' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Vapor\\VaporServiceProvider',
    ),
  ),
  'linkeys/signed-url' => 
  array (
    'providers' => 
    array (
      0 => 'Linkeys\\UrlSigner\\Providers\\UrlSignerServiceProvider',
    ),
    'aliases' => 
    array (
      'UrlSigner' => 'Linkeys\\UrlSigner\\Link',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'socialiteproviders/manager' => 
  array (
    'providers' => 
    array (
      0 => 'SocialiteProviders\\Manager\\ServiceProvider',
    ),
  ),
  'twigger/unioncloud' => 
  array (
    'providers' => 
    array (
      0 => 'Twigger\\UnionCloud\\API\\UnionCloudServiceProvider',
    ),
  ),
);