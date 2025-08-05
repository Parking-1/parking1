<?php

namespace App\Helpers;

class GeneradorXmlHelper
{
    public static function generarXmlFactura($emisor, $receptor, $items, $total, $fecha, $formaPago)
    {
        $xml = new \SimpleXMLElement('<factura></factura>');

        $xmlEmisor = $xml->addChild('emisor');
        $xmlEmisor->addChild('nombre', $emisor['nombre']);
        $xmlEmisor->addChild('nit', $emisor['nit']);
        $xmlEmisor->addChild('direccion', $emisor['direccion']);

        $xmlReceptor = $xml->addChild('receptor');
        $xmlReceptor->addChild('nombre', $receptor['nombre']);
        $xmlReceptor->addChild('nit', $receptor['nit']);
        $xmlReceptor->addChild('direccion', $receptor['direccion']);

        $xmlItems = $xml->addChild('items');
        foreach ($items as $item) {
            $xmlItem = $xmlItems->addChild('item');
            $xmlItem->addChild('descripcion', $item['descripcion']);
            $xmlItem->addChild('cantidad', $item['cantidad']);
            $xmlItem->addChild('precio_unitario', $item['precio_unitario']);
            $xmlItem->addChild('total', $item['total']);
        }

        $xml->addChild('total', $total);
        $xml->addChild('fecha', $fecha);
        $xml->addChild('forma_pago', $formaPago);

        return $xml->asXML();
    }
}

