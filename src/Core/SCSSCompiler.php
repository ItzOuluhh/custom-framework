<?php

namespace Cloudstorage\Core;

use ScssPhp\ScssPhp\Compiler;

class SCSSCompiler
{
    public static function compile($inputFile, $outputFile)
    {
        $scss = new Compiler();

        $scssContent = file_get_contents($inputFile);
        $cssContent = $scss->compileString($scssContent);

        file_put_contents($outputFile, $cssContent);
    }
}
