<?php
require 'databasehandler.php'; // Ensure this connects to your database
require 'vendor/autoload.php'; // Load Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

$db = new DatabaseHandler();
$pdo = $db->getPDO();

// Fetch products from the database
$stmt = $pdo->query("SELECT name, quantity FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create the HTML content for the PDF
$html = "<h2>Product Report</h2>";
$html .= "<table border='1' cellpadding='5' cellspacing='0' width='100%'>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
            </tr>";

foreach ($products as $product) {
    $html .= "<tr>
                <td>{$product['name']}</td>
                <td>{$product['quantity']}</td>
              </tr>";
}

$html .= "</table>";

// Initialize Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Send PDF as a download
$dompdf->stream("Product_Report.pdf", ["Attachment" => true]);
exit();
?>
