<?php
  // Disable loading of external entities to prevent XXE attacks
  libxml_disable_entity_loader(true);

  $xmlfile = file_get_contents('php://input');
  $dom = new DOMDocument();

  // Suppress errors due to invalid XML
  libxml_use_internal_errors(true);

  try {
      // Load XML without resolving external entities
      $dom->loadXML($xmlfile, LIBXML_COMPACT | LIBXML_NOBLANKS);

      // Process and output XML content
      echo $dom->textContent;

  } catch (Exception $e) {
      // Handle any exceptions or XML parsing errors
      echo "Error: " . $e->getMessage();
  }
?>
