<?php

namespace TYlnt\Vite\Tests;

use CodeIgniter\Test\CIUnitTestCase;
use TYlnt\Vite\Vite;

class ViteTest extends CIUnitTestCase
{
    protected function tearDown(): void
    {
        $this->cleanViteManifest();
        $this->cleanViteHotFile();
    }

    public function testViteWithJsOnly()
    {
        $this->makeViteManifest();

        $result = (new Vite)('resources/js/app.js');

        $this->assertSame('<script type="module" src="https://example.com/build/assets/app.versioned.js"></script>', $result->toHtml());
    }

    public function testViteWithCssAndJs()
    {
        $this->makeViteManifest();

        $result = (new Vite)(['resources/css/app.css', 'resources/js/app.js']);

        $this->assertSame(
            '<link rel="stylesheet" href="https://example.com/build/assets/app.versioned.css" />'
            .'<script type="module" src="https://example.com/build/assets/app.versioned.js"></script>',
            $result->toHtml()
        );
    }

    public function testViteWithCssImport()
    {
        $this->makeViteManifest();

        $result = (new Vite)('resources/js/app-with-css-import.js');

        $this->assertSame(
            '<link rel="stylesheet" href="https://example.com/build/assets/imported-css.versioned.css" />'
            .'<script type="module" src="https://example.com/build/assets/app-with-css-import.versioned.js"></script>',
            $result->toHtml()
        );
    }

    public function testViteWithSharedCssImport()
    {
        $this->makeViteManifest();

        $result = (new Vite)(['resources/js/app-with-shared-css.js']);

        $this->assertSame(
            '<link rel="stylesheet" href="https://example.com/build/assets/shared-css.versioned.css" />'
            .'<script type="module" src="https://example.com/build/assets/app-with-shared-css.versioned.js"></script>',
            $result->toHtml()
        );
    }

    public function testViteHotModuleReplacementWithJsOnly()
    {
        $this->makeViteHotFile();

        $result = (new Vite)('resources/js/app.js');

        $this->assertSame(
            '<script type="module" src="http://localhost:3000/@vite/client"></script>'
            .'<script type="module" src="http://localhost:3000/resources/js/app.js"></script>',
            $result->toHtml()
        );
    }

    public function testViteHotModuleReplacementWithJsAndCss()
    {
        $this->makeViteHotFile();

        $result = (new Vite)(['resources/css/app.css', 'resources/js/app.js']);

        $this->assertSame(
            '<script type="module" src="http://localhost:3000/@vite/client"></script>'
            .'<link rel="stylesheet" href="http://localhost:3000/resources/css/app.css" />'
            .'<script type="module" src="http://localhost:3000/resources/js/app.js"></script>',
            $result->toHtml()
        );
    }

    protected function makeViteManifest()
    {
        $config = config('App');
        $config->baseURL = 'https://example.com/';

        if (! file_exists($this->publicPath('build'))) {
            mkdir($this->publicPath('build'));
        }

        $manifest = json_encode([
            'resources/js/app.js' => [
                'file' => 'assets/app.versioned.js',
            ],
            'resources/js/app-with-css-import.js' => [
                'file' => 'assets/app-with-css-import.versioned.js',
                'css' => [
                    'assets/imported-css.versioned.css',
                ],
            ],
            'resources/js/app-with-shared-css.js' => [
                'file' => 'assets/app-with-shared-css.versioned.js',
                'imports' => [
                    '_someFile.js',
                ],
            ],
            'resources/css/app.css' => [
                'file' => 'assets/app.versioned.css',
            ],
            '_someFile.js' => [
                'css' => [
                    'assets/shared-css.versioned.css',
                ],
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        file_put_contents($this->publicPath('build/manifest.json'), $manifest);
    }

    protected function cleanViteManifest()
    {
        if (file_exists($this->publicPath('build/manifest.json'))) {
            unlink($this->publicPath('build/manifest.json'));
        }

        if (file_exists($this->publicPath('build'))) {
            rmdir($this->publicPath('build'));
        }
    }

    protected function makeViteHotFile()
    {
        file_put_contents($this->publicPath('hot'), 'http://localhost:3000');
    }

    protected function cleanViteHotFile()
    {
        if (file_exists($this->publicPath('hot'))) {
            unlink($this->publicPath('hot'));
        }
    }

    protected function publicPath($path)
    {
        return PUBLICPATH.$path;
    }
}
