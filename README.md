# Vite Backend Integration for CodeIgniter 4

## Introduction

[Vite](https://vitejs.dev/) is a modern frontend build tool that provides an extremely fast development environment and bundles your code for production. This is backend integration for CodeIgniter 4 to load your assets for development and production.

## Installation

### ThirdParty

You can install it's as **ThirdParty**:

```bash
cd app/ThirdParty

git clone https://github.com/trianayulianto/vite-codeigniter-4.git
```

Set autoload in `app/Config/Autoload.php`

```php
public $psr4 = [
    // others
    'Inertia'     => APPPATH . 'ThirdParty/vite-codeigniter-4/src'
];
```

## Usage

### Install Vite and the Laravel Plugin

First, you will need to install [Vite](https://vitejs.dev/) using your npm package manager of choice:

```shell
npm install --save-dev vite
```

You may also need to install additional Vite plugins for your project, such as the Vue or React plugins:

```shell
npm install --save-dev @vitejs/plugin-vue
```

```shell
npm install --save-dev @vitejs/plugin-react
```

### Configure Vite

Thanks to Laravel, configuring Vite has become easier with their plugin. See [Laravel Vite Plugin](https://www.npmjs.com/package/laravel-vite-plugin).

```shell
npm install --save-dev laravel-vite-plugin
```

Update environment variables

```
APP_URL="http://localhost:8000"

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

Create a `vite.config.js` file in the root of your project:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';
// import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        // react(),
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
    ],
});
```

If you are building an **SPA**, you will get a better developer experience by removing the CSS entry point above and **importing your CSS from Javascript**.

### Loading Your Scripts And Styles

With your Vite entry points configured, you only need reference them in a `vite()` hepler that you add to the `<head>` of your application's root template:

```php
...
    <!-- ViteJs Helper -->
    <?= vite('resources/js/app.js') ?>
...
```

If needed, you may also specify the build path of your compiled assets when invoking the `vite()` hepler:

```php
...
    <!-- Given build path is relative to public path. -->
    <?= vite('resources/js/app.js', 'vendor/dist') ?>
...
```

### React

If you are using React and hot-module replacement, you will need to include an additional helper before the `vite()` helper:

```php
...
    <!-- ViteJs Helper -->
    <?= vite_react_refresh() ?>
    <?= vite('resources/js/app.js') ?>
...
```

## Testing

``` bash
composer test
```

## Inspires

- [Laravel Vite](https://laravel.com/docs/9.x/vite)
