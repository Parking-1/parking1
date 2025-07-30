<?php

namespace App\Helpers;

class FirmaXmlHelper
{
    public static function firmarXml($xmlSinFirmar)
    {
        $certificadoPath = storage_path('app/certs/certificate.crt');
        $clavePrivadaPath = storage_path('app/certs/private.key');

        // Cargar certificado y clave
        $certificado = file_get_contents($certificadoPath);
        $clavePrivada = file_get_contents($clavePrivadaPath);

        // Crear una nueva instancia DOMDocument
        $dom = new \DOMDocument();
        $dom->loadXML($xmlSinFirmar);

        // Canonicalización
        $data = $dom->C14N();

        // Firmar los datos
        openssl_sign($data, $firmaBinaria, $clavePrivada, OPENSSL_ALGO_SHA256);
        $firmaBase64 = base64_encode($firmaBinaria);

        // Agregar la firma al XML
        $firmaElement = $dom->createElement("Firma", $firmaBase64);
        $dom->documentElement->appendChild($firmaElement);

        return $dom->saveXML();
    }}
