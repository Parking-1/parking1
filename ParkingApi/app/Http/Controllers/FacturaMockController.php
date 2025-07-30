<?php

namespace App\Http\Controllers; // 👈 ESTA LÍNEA es necesaria

use App\Services\FacturaElectronica\FacturaElectronicaInterface;

use Illuminate\Http\Request;

use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use App\Helpers\FirmaXmlHelper;
//use SimpleXMLElement;

class FacturaMockController extends Controller
{
    public function pruebaMockFactura()
{
    $emisor = [
        'nombre' => 'Parqueadero El Centro',
        'nit' => '900123456-1',
        'direccion' => 'Calle 10 # 5-30',
    ];

    $receptor = [
        'nombre' => 'Juan Pérez',
        'nit' => '123456789',
        'direccion' => 'Cra 45 # 12-15',
    ];

    $items = [
        [
            'descripcion' => 'Servicio de parqueo - Carro',
            'cantidad' => 1,
            'precio_unitario' => 5000,
            'total' => 5000,
        ],
        [
            'descripcion' => 'Lavado',
            'cantidad' => 1,
            'precio_unitario' => 8000,
            'total' => 8000,
        ],
    ];

    $total = 13000;
    $fecha = now()->format('Y-m-d H:i:s');
    $forma_pago = 'Efectivo';

    $factura = new \SimpleXMLElement('<Factura></Factura>');

    $emisorXML = $factura->addChild('Emisor');
    $emisorXML->addChild('Nombre', htmlspecialchars($emisor['nombre']));
    $emisorXML->addChild('NIT', htmlspecialchars($emisor['nit']));
    $emisorXML->addChild('Direccion', htmlspecialchars($emisor['direccion'] ?? ''));

    $receptorXML = $factura->addChild('Receptor');
    $receptorXML->addChild('Nombre', htmlspecialchars($receptor['nombre']));
    $receptorXML->addChild('NIT', htmlspecialchars($receptor['nit']));
    $receptorXML->addChild('Direccion', htmlspecialchars($receptor['direccion']));

    $detalle = $factura->addChild('Detalle');

    foreach ($items as $item) {
        $itemXML = $detalle->addChild('Item');
        $itemXML->addChild('Descripcion', htmlspecialchars($item['descripcion']));
        $itemXML->addChild('Cantidad', $item['cantidad']);
        $itemXML->addChild('PrecioUnitario', $item['precio_unitario']);
        $itemXML->addChild('Total', $item['total']);
    }

    $factura->addChild('Total', $total);
    $factura->addChild('Fecha', $fecha);
    $factura->addChild('FormaPago', $forma_pago);

    header('Content-type: text/xml');
    echo $factura->asXML();

     // Guardar el XML temporalmente para firmarlo después
        $rutaXml = storage_path('app/facturas/factura_mock.xml');
        $factura->asXML($rutaXml);

        return response($factura->asXML(), 200)->header('Content-Type', 'application/xml');
}

public function firmarXmlDePrueba()
{
    $xmlPath = storage_path('app/facturas/factura_mock.xml');
    $certPath = storage_path('certificados-prueba/certificate.pem');
    $keyPath = storage_path('certificados-prueba/private.key');


    if (!file_exists($xmlPath) || !file_exists($certPath) || !file_exists($keyPath)) {
            return response()->json(['error' => 'Archivo XML o certificados no encontrados.'], 404);
        }

    $doc = new \DOMDocument();
    $doc->load($xmlPath);

    $objDSig = new XMLSecurityDSig();
    $objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
    $objDSig->addReference(
        $doc,
        XMLSecurityDSig::SHA1,
        ['http://www.w3.org/2000/09/xmldsig#enveloped-signature']
    );

    $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, ['type'=>'private']);
    $objKey->loadKey($keyPath, true);

    $objDSig->sign($objKey);
    $objDSig->add509Cert(file_get_contents($certPath));
    $objDSig->appendSignature($doc->documentElement);

    $signedPath = storage_path('app/facturas/factura_mock_firmada.xml');
    $doc->save($signedPath);

    return response()->download($signedPath);
}


}


