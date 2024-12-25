<?php

namespace Joinbiz\Utility\Parser\Ofx;

use SimpleXMLElement;

class ParserService
{
    /**
     * @throws \Exception
     */
    protected function createOfx(SimpleXMLElement $xml)
    {
        return new Ofx($xml);
    }
    public function loadFromFile($ofxFile)
    {
        if (!file_exists($ofxFile)) {
            throw new \InvalidArgumentException("File '{$ofxFile}' could not be found");
        }

        return $this->loadFromString(file_get_contents($ofxFile));
    }

    public function loadFromString($ofxContent)
    {
        $ofxContent = str_replace(["\r\n", "\r"], "\n", $ofxContent);
        $ofxContent = utf8_encode($ofxContent);

        $sgmlStart = stripos($ofxContent, '<OFX>');
        $ofxHeader =  trim(substr($ofxContent, 0, $sgmlStart));
        $header = $this->parseHeader($ofxHeader);

        $ofxSgml = trim(substr($ofxContent, $sgmlStart));
        if (stripos($ofxHeader, '<?xml') === 0) {
            $ofxXml = $ofxSgml;
        } else {
            $ofxSgml = $this->conditionallyAddNewlines($ofxSgml);
            $ofxXml = $this->convertSgmlToXml($ofxSgml);
        }

        $xml = $this->xmlLoadString($ofxXml);

        $ofx = $this->createOfx($xml);
        $ofx->buildHeader($header);

        return $ofx;
    }
    private function xmlLoadString($xmlString)
    {
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlString);

        if ($errors = libxml_get_errors()) {
            throw new \RuntimeException('Failed to parse OFX: ' . var_export($errors, true));
        }

        return $xml;
    }
    private function conditionallyAddNewlines($ofxContent)
    {
        if (preg_match('/<OFX>.*<\/OFX>/', $ofxContent) === 1) {
            return str_replace('<', "\n<", $ofxContent); // add line breaks to allow XML to parse
        }

        return $ofxContent;
    }
    private function closeUnclosedXmlTags($line)
    {
        // Special case discovered where empty content tag wasn't closed
        $line = trim($line);
        if (preg_match('/<MEMO>$/', $line) === 1) {
            return '<MEMO></MEMO>';
        }

        // Matches: <SOMETHING>blah
        // Does not match: <SOMETHING>
        // Does not match: <SOMETHING>blah</SOMETHING>
        if (preg_match(
            "/<([A-Za-z0-9.]+)>([\wà-úÀ-Ú0-9\.\-\_\+\, ;:\[\]\'\&\/\\\*\(\)\+\{\|\}\!\£\$\?=@€£#%±§~`\"]+)$/",
            $line,
            $matches
        )) {
            return "<{$matches[1]}>{$matches[2]}</{$matches[1]}>";
        }
        return $line;
    }

    private function parseHeader($ofxHeader)
    {
        $header = [];


        $ofxHeader = trim($ofxHeader);
        // Remove empty new lines.
        $ofxHeader = preg_replace('/^\n+/m', '', $ofxHeader);

        // Check if it's an XML file (OFXv2)
        if(preg_match('/^<\?xml/', $ofxHeader) === 1) {
            // Only parse OFX headers and not XML headers.
            $ofxHeader = preg_replace('/<\?xml .*?\?>\n?/', '', $ofxHeader);
            $ofxHeader = preg_replace(['/"/', '/\?>/', '/<\?OFX/i'], '', $ofxHeader);
            $ofxHeaderLine = explode(' ', trim($ofxHeader));

            foreach ($ofxHeaderLine as $value) {
                $tag = explode('=', $value);
                $header[$tag[0]] = $tag[1];
            }

            return $header;
        }

        $ofxHeaderLines = explode("\n", $ofxHeader);
        foreach ($ofxHeaderLines as $value) {
            $tag = explode(':', $value);
            $header[$tag[0]] = $tag[1];
        }

        return $header;
    }
    private function convertSgmlToXml($sgml)
    {
        $sgml = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $sgml);

        $lines = explode("\n", $sgml);
        $tags = [];

        foreach ($lines as $i => &$line) {
            $line = trim($this->closeUnclosedXmlTags($line)) . "\n";

            // Matches tags like <SOMETHING> or </SOMETHING>
            if (!preg_match("/^<(\/?[A-Za-z0-9.]+)>$/", trim($line), $matches)) {
                continue;
            }

            // If matches </SOMETHING>, looks back and replaces all tags like
            // <OTHERTHING> to <OTHERTHING/> until finds the opening tag <SOMETHING>
            if ($matches[1][0] == '/') {
                $tag = substr($matches[1], 1);

                while (($last = array_pop($tags)) && $last[1] != $tag) {
                    $lines[$last[0]] = "<{$last[1]}/>";
                }
            } else {
                $tags[] = [$i, $matches[1]];
            }
        }

        return implode("\n", array_map('trim', $lines));
    }
}