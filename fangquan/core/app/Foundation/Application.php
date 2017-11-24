<?php

namespace App\Foundation;

use Illuminate\Foundation\Application as BaseApplication;


class Application extends BaseApplication
{

    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        parent::__construct($basePath);
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents(base_path('../composer.json')), true);

        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array)$path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path() . '/../' . $pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new \RuntimeException('Unable to detect application namespace.');
    }

}