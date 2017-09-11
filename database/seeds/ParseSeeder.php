<?php

use Illuminate\Database\Seeder;

class ParseSeeder extends Seeder
{
    private $path = 'unipark_dump';

    protected function parse($dbName)
    {
        $file = database_path("$this->path/$dbName");

        if(file_exists($file)) {

            $handle = @fopen($file, "r");
            if ($handle) {
                $json = [];
                while (($buffer = fgets($handle, 9096)) !== false) {
                    $json[] =  json_decode($buffer);
                }

                if (!feof($handle)) {
                    echo "Error: unexpected fgets() fail\n";
                }
                fclose($handle);


                return $json;
            }
        }
        return false;
    }

    protected function parseObject($dbName)
    {
        $file = database_path("$this->path/$dbName");

        if(file_exists($file)) {
            return json_decode(file_get_contents($file));
        }
        return false;
    }




}