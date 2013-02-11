<?php


    //path to directory to scan
    $directory = "xml/";

    //Delete old xml files
    foreach(glob($directory.'*.*') as $v){
    unlink($v);
    }

    // Download & extract new zip file with xml's to directory
    $zip = new ZipArchive;     
        $res = $zip->open('https://api.wazzupsoftware.com/MultipleListingService/a95aff8f-1a5e-44cc-9438-37aaff2c255f/zip');
        if ($res === TRUE) {
         $zip->extractTo($directory);
         $zip->close();
         echo 'Unzip was successful';
         } else {
         echo 'Unzip was not successful';
    }

    //get all xml files with a .xml extension.
    $filenames = glob($directory . "*.xml");

    $docList = new DOMDocument();

    $root = $docList->createElement('documents');
    $docList->appendChild($root);

    foreach($filenames as $filename) {

        $doc = new DOMDocument();
        $doc->load($filename);

        $xmlString = $doc->saveXML($doc->documentElement);

        $xpath = new DOMXPath($doc);
        $query = "//RealEstateProperty";  // this is the name of the ROOT element

        $nodelist = $xpath->evaluate($query, $doc->documentElement);

        if( $nodelist->length > 0 ) {

            $node = $docList->importNode($nodelist->item(0), true);

            $xmldownload = $docList->createElement('document');
            $xmldownload->setAttribute("filename", $filename);
            $xmldownload->appendChild($node);

            $root->appendChild($xmldownload);
        }

    }

    echo $docList->saveXML();
?>