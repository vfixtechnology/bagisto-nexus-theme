
# Bagisto Nexus Theme
Bagisto custom theme for better user experience &amp; conversion

# Nexus Theme for Bagisto by Vfix Technology

A premium, high-performance theme for Bagisto e-commerce platform with modern design and seamless integration.

## Step-by-Step: Creating a NexusTheme Package in Bagisto
To set up a custom theme package in Bagisto, follow these steps:


1. Navigate to the packages/ Directory in bagisto : Open your terminal and go to the root of your Bagisto project, then run:
```php
cd packages/
```

3. Create the Vendor and Package Folders
Now create a folder for your vendor (e.g., Vfixtechnology) and inside it, create a new directory for the package (e.g., NexusTheme):
```php
mkdir -p Vfixtechnology/NexusTheme
```

4. Download the NexusTheme package code (and upload to packages/Vfixtechnology/).
#### Download the code and upload it to the packages/Vfixtechnology/ directory in your Bagisto root folder:
#### ex: packages/Vfixtechnology/NexusTheme

2. Register the Service Provider
##### Go to bootstrap/app.php and add the following service provider:
```php
Vfixtechnology\NexusTheme\Providers\NexusThemeServiceProvider::class,
```

3.  Update composer.json
##### Under the autoload > psr-4 section, add the following line:
```php
"Vfixtechnology\\NexusTheme\\": "packages/Vfixtechnology/NexusTheme/src"
```

4. Dump Autoload
##### Run the following command to regenerate the Composer autoload files:
```php
composer dump-autoload
```

5. Configure the Theme
##### Open config/themes.php and under the shop section, add a new theme entry:
```php
'nexus-theme' => [
    'name'        => 'Nexus',
    'assets_path' => 'public/themes/nexus-theme/default',
    'views_path'  => 'resources/themes/nexus-theme/views',

    'vite'        => [
        'hot_file'                 => 'shop-nexus-theme-vite.hot',
        'build_directory'          => 'themes/shop/nexus-theme/build',
        'package_assets_directory' => 'src/Resources/assets',
    ],
],
```

6. Build Assets
##### Navigate to the theme directory and run the following commands:
###### cd packages/Vfixtechnology/NexusTheme
```php
npm install && npm run build
```

7. Now Publish vendor: 
##### Run the following Artisan command to publish the theme's assets: (make sure for this need to navigate to main directory of project)
```php
php artisan vendor:publish --provider="Vfixtechnology\NexusTheme\Providers\NexusThemeServiceProvider"
```

9. Clear Cache: 
```php
php artisan optimize:clear
```

8. Activate the Theme : Dashboard → Settings → Channels
##### Select the Nexus theme from the dropdown and save your changes.



## Support This Project

If you find this package useful, please consider showing your support by:

⭐ Giving the repository a star on GitHub  
📣 Sharing it with your developer community  
🐛 Reporting any issues you encounter  

Your support helps maintain and improve this project for everyone.

#### For any help or customization, visit https://www.vfixtechnology.com or email us info@vfixtechnology.com
