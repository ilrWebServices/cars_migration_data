<?php
$rows = [
  [
    'id',
    'name',
    'url',
    'industry',
    'img_url',
    'img_alt',
  ]
];

$doc = new DOMDocument();
$doc->loadHTMLFile(__DIR__ . '/../src/orgs.html');

$xpath = new DOMXpath($doc);
$orgs = $xpath->query("//html/body/div");

/** @var \DOMElement $org */
foreach ($orgs as $key => $org) {
  /** @var \DOMElement $link */
  $link = $org->getElementsByTagName('a')->item(0);
  /** @var \DOMElement $img */
  $img = $org->getElementsByTagName('img')->item(0);
  $rows[] = [
    $key,
    preg_replace('/\s+/', ' ', $link->textContent),
    $link->getAttribute('href'),
    trim(preg_replace('/\s+/', ' ', str_replace($link->textContent, '', $org->textContent))),
    $img->getAttribute('src'),
    $img->getAttribute('alt'),
  ];
}

$fp = fopen(__DIR__ . '/../orgs.csv', 'w');

foreach ($rows as $row) {
    fputcsv($fp, $row);
}

fclose($fp);
