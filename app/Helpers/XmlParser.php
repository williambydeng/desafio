<?php

namespace App\Helpers;

use SimpleXMLElement;

class XmlParser
{
    public static function xmlToArray(SimpleXMLElement $xml)
    {
        $result = [];

        foreach ($xml->children() as $child) {
            $item = [
                'titulo' => (string) $child['titulo'],
                'pagina' => (int) $child['pagina'],
            ];

            if ($child->count() > 0) {
                $item['subindices'] = self::xmlToArray($child);
            }

            $result[] = $item;
        }

        return $result;
    }
}
