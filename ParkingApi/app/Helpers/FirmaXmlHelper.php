<?php

namespace App\Helpers;

class FirmaXmlHelper
{
    public static function firmarXml(string $xmlSinFirmar): string
    {
        $certificadoPath = storage_path('app/certs/certificate.crt');
        $clavePrivadaPath = storage_path('app/certs/private.key');

        // Validar existencia de archivos
        if (!file_exists($certificadoPath) || !file_exists($clavePrivadaPath)) {
            throw new \Exception("Certificado o clave privada no encontrados.");
        }

        // Cargar contenido de certificado y clave
        $certificado = file_get_contents($certificadoPath);
        $clavePrivada = file_get_contents($clavePrivadaPath);

        if ($certificado === false || $clavePrivada === false) {
            throw new \Exception("Error al leer los archivos de certificado o clave.");
        }

        // Cargar XML en DOMDocument
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->loadXML($xmlSinFirmar)) {
            throw new \Exception("El XML proporcionado no es válido.");
        }

        // Canonicalizar contenido
        $data = $dom->C14N();

        // Firmar el contenido
        $firmaBinaria = null;
        if (!openssl_sign($data, $firmaBinaria, $clavePrivada, OPENSSL_ALGO_SHA256)) {
            throw new \Exception("Error al firmar el XML.");
        }

        $firmaBase64 = base64_encode($firmaBinaria);

        // Agregar nodo <Firma> al XML
        $firmaElement = $dom->createElement("Firma", $firmaBase64);
        $dom->documentElement->appendChild($firmaElement);

        return $dom->saveXML();
    }
}
