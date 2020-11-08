<?php

namespace App\Traits;


trait ConvertCsv
{
    /**
     * @param $filePath
     * @param $separator
     * @param bool $firstLine
     * @return array
     * @throws \Exception
     */
    public function convertCsvReturnArray($filePath, $separator, $firstLine = true)
    {
        $data = [];
        $keys = [];
        $withKeys = [];

        if ($gestor = fopen($filePath, "r")) {
            while (($datos = fgetcsv($gestor, 0, $separator)) !== FALSE) {

                if($firstLine){
                    $ala = [];
                    for($i = 0; $i<count($datos); $i++){
                        $ala[$i] = $datos[$i];
                    }
                    $keys[] = $ala;

                } else {

                    for($j = 0; $j<count($keys[0]); $j++){
//                        if($keys[$j] == 'Acción'){
//                            $withKeys[$keys[0][$j]] = $datos[$j]);
//                        } else {
                        $withKeys[$keys[0][$j]] = $datos[$j];
//                        }
                    }

                    $data[] = $withKeys;

                }
                $firstLine = false;
            }

            fclose($gestor);
        } else {

            throw new \Exception('File found. Error mapping CSV.');
        }

        return $data;
    }
}
