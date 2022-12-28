<?php

namespace TYlnt\Vite\Facades;

use TYlnt\Vite\Config\Services;

/**
 * @method static string|null cspNonce()
 * @method static string useCspNonce(?string $nonce = null)
 * @method static $this useIntegrityKey(string|false $key)
 * @method static $this withEntryPoints(array $entryPoints)
 * @method static string hotFile()
 * @method static $this useHotFile(string $path)
 * @method static $this useBuildDirectory(string $path)
 * @method static $this useScriptTagAttributes(callable|array $attributes)
 * @method static $this useStyleTagAttributes(callable|array $attributes)
 * @method static \Vite\Support\HtmlString __invoke(string|string[] $entrypoints, string|null $buildDirectory = null)
 * @method static \Vite\Support\HtmlString|void reactRefresh()
 * @method static string asset(string $asset, string|null $buildDirectory = null)
 * @method static string|null manifestHash($buildDirectory = null)
 * @method static string toHtml()
 *
 * @see \TYlnt\Vite\Vite
 */
class Vite
{
    public static function __callStatic($method, $arguments)
    {
        return Services::getSharedInstance('vite')->{$method}(...$arguments);
    }
}
