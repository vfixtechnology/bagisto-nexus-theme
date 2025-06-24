
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
##### Go to bootstrap/providers.php and add the following service provider:
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
            'assets_path' => 'public/themes/shop/nexus',
         // 'views_path' => 'resources/themes/nexus-theme/views', // Use this if you want to publish assets and override them
           'views_path' => 'packages/Vfixtechnology/NexusTheme/src/Resources/views', // Use this for hot reloading and live changes directly in the package

            'vite'        => [
                'hot_file'                 => 'shop-nexus-vite.hot',
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

7. Clear Cache: 
```php
php artisan optimize:clear
```

9. Activate the Theme : Dashboard → Settings → Channels
##### Select the Nexus theme from the dropdown and save your changes.

10. Note: After applying a new theme, the homepage may appear blank. To restore the previous homepage content, follow these steps:
##### 1. Navigate to Dashboard > Theme.
##### 2. For each section/item listed, change the theme from Default to Nexus.
##### 3. This will reinstate all the original homepage components.
##### 4. 👉 During development, to avoid caching, add the following line in your .env file: : RESPONSE_CACHE_ENABLED=false




## Support This Project

If you find this package useful, please consider showing your support by:

⭐ Giving the repository a star on GitHub  
📣 Sharing it with your developer community  
🐛 Reporting any issues you encounter  

Your support helps maintain and improve this project for everyone.

#### For any help or customization, visit https://www.vfixtechnology.com or email us info@vfixtechnology.com
