<?
require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';

// Import library
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Regression\LeastSquares;

$samples = [[49.7]];
$targets = [51.7];

// Initialize regression engine
$regression = new LeastSquares();
// Train engine
$regression->train($samples, $targets);
// Predict using trained engine
echo "<br>" . $regression->predict([-2.5]);


?>