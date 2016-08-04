<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

class YamlReader
{
    public static function readYaml($filename) {
        $value = NULL;
        try {
            $value = Yaml::parse(file_get_contents($filename));
            print("Successfully read $filename\n");
        } catch (ParseException $e) {
            printf("Unable to parse string: %s", $e->getMessage());
        }

        return $value;
    }
}
