<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';

// Import library
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Regression\LeastSquares;

class Matrix
{
    /**
     * Matrix Constructor.
     *
     * Initialize the Matrix object.
     *
     * @param array $matrix The matrix as an array.
     *
     * @throws \InvalidArgumentException Throws exception if jagged array is given.
     */
    public function __construct(array $matrix = [])
    {
        // Insure matrix keys are numeric and start with 0 by using array_values().
        $matrix = array_values($matrix);
        $this->rows = count($matrix);
        $this->columns = count($matrix[0]);
        foreach ($matrix as $i => $row) {
            $row = array_values($row);
            if ($this->columns !== count($row)) {
                throw new \InvalidArgumentException('Invalid matrix');
            }
            $this->mainMatrix[$i] = $row;
        }
    }
    /**
     * Add matrix2 to matrix object that calls this method.
     *
     * @param Matrix $matrix2
     *
     * @return Matrix Note that original matrix is left unchanged
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function add(Matrix $matrix2)
    {
        if (($this->rows !== $matrix2->numRows()) || ($this->columns !== $matrix2->numColumns())) {
            throw new \DomainException('Matrices are not the same size!');
        }
        $newMatrix = [];
        foreach ($this->mainMatrix as $i => $row) {
            foreach ($row as $j => $column) {
                $newMatrix[$i][$j] = $column + $matrix2->getElementAt($i, $j);
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Compute the determinant of the square matrix on which this method is called
     *
     * @link http://mathworld.wolfram.com/DeterminantExpansionbyMinors.html
     * @return int|double (depends on input)
     * @throws \RangeException
     * @throws \InvalidArgumentException
     */
    public function determinant()
    {
        if (!$this->isSquareMatrix()) {
            throw new \RangeException('Not a square matrix!');
        }
        $rows = $this->rows;
        $columns = $this->columns;
        $determinant = 0;
        if ($rows === 1 && $columns === 1) {
            return $this->mainMatrix[0][0];
        }
        if ($rows === 2 && $columns === 2) {
            $determinant = $this->mainMatrix[0][0] * $this->mainMatrix[1][1] -
                $this->mainMatrix[0][1] * $this->mainMatrix[1][0];
        } else {
            /** @noinspection ForeachInvariantsInspection */
            for ($j = 0; $j < $columns; ++$j) {
                $subMatrix = $this->getSubMatrix(0, $j);
                if ($j % 2 === 0) {
                    $determinant += $this->mainMatrix[0][$j] * $subMatrix->determinant();
                } else {
                    $determinant -= $this->mainMatrix[0][$j] * $subMatrix->determinant();
                }
            }
        }
        return $determinant;
    }
    /**
     * Display the matrix
     * Formatted display of matrix for debugging.
     */
    public function displayMatrix()
    {
        $rows = $this->rows;
        $cols = $this->columns;
        $debugString = "Order of the matrix is ($rows rows X $cols columns)\n";
        foreach ($this->mainMatrix as $row) {
            $debugString .= implode(', ', $row) . "\n";
        }
        return $debugString;
    }
    /**
     * Return element found at location $row, $col.
     *
     * @param int $row
     * @param int $col
     *
     * @return int|double (depends on input)
     */
    public function getElementAt($row, $col)
    {
        return $this->mainMatrix[$row][$col];
    }
    /**
     * Get the inner array stored in matrix object.
     *
     * @return array
     */
    public function getInnerArray()
    {
        return $this->mainMatrix;
    }
    /**
     * Return the sub-matrix after crossing out the $crossX and $crossY row and column respectively.
     *
     * Part of determinant expansion by minors method.
     *
     * @param int $crossX
     * @param int $crossY
     *
     * @return Matrix
     * @throws \InvalidArgumentException
     */
    public function getSubMatrix($crossX, $crossY)
    {
        $rows = $this->rows;
        $columns = $this->columns;
        $newMatrix = [];
        $p = 0; // sub-matrix row counter
		echo "rows = ".$rows."<br>";
		echo "columns = ".$columns."<br>";
        for ($i = 0; $i < $rows; ++$i) {
            $q = 0; // sub-matrix col counter
            if ($crossX !== $i) {
                for ($j = 0; $j < $columns; ++$j) {
                    if ($crossY !== $j) {
                        $newMatrix[$p][$q] = $this->getElementAt($i, $j);
                        //$matrix[$i][$j];
                        ++$q;
                    }
                }
                ++$p;
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Compute the inverse of the matrix on which this method is found (A*A(-1)=I).
     *
     * (cofactor(a))T/(det a)
     *
     * @link http://www.mathwords.com/i/inverse_of_a_matrix.htm
     * @return Matrix
     * @throws \InvalidArgumentException
     * @throws \RangeException
     */
    public function inverse()
    {
        if (!$this->isSquareMatrix()) {
            throw new \RangeException('Not a square matrix!');
        }
        $newMatrix = [];
        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $this->rows; ++$i) {
            /** @noinspection ForeachInvariantsInspection */
            for ($j = 0; $j < $this->columns; ++$j) {
                $subMatrix = $this->getSubMatrix($i, $j);
                if (($i + $j) % 2 === 0) {
                    $newMatrix[$i][$j] = $subMatrix->determinant();
                } else {
                    $newMatrix[$i][$j] = -$subMatrix->determinant();
                }
            }
        }
        $cofactorMatrix = new Matrix($newMatrix);
        return $cofactorMatrix->transpose()
                              ->scalarDivide($this->determinant());
    }
    /**
     * Is this a square matrix?
     *
     * Determinants and inverses only exist for square matrices!
     *
     * @return bool
     */
    public function isSquareMatrix()
    {
        return $this->rows === $this->columns;
    }
    /**
     * Multiply matrix2 into matrix object that calls this method.
     *
     * @param Matrix $matrix2
     *
     * @return Matrix Note that original matrix is left unaltered
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function multiply(Matrix $matrix2)
    {
        $columns2 = $matrix2->numColumns();
        if ($this->columns !== $matrix2->numRows()) {
            throw new \DomainException('Incompatible matrix types supplied');
        }
        $newMatrix = [];
        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $this->rows; $i++) {
            /** @noinspection ForeachInvariantsInspection */
            for ($j = 0; $j < $columns2; $j++) {
                $newMatrix[$i][$j] = 0;
                /** @noinspection ForeachInvariantsInspection */
                for ($ctr = 0; $ctr < $this->columns; $ctr++) {
                    $newMatrix[$i][$j] += $this->mainMatrix[$i][$ctr] *
                        $matrix2->getElementAt($ctr, $j);
                }
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Number of columns in the matrix
     *
     * @return int
     */
    public function numColumns()
    {
        return count($this->mainMatrix[0]);
    }
    /**
     * Number of rows in the matrix
     *
     * @return int
     */
    public function numRows()
    {
        return count($this->mainMatrix);
    }
    /**
     * Divide every element of matrix on which this method is called by the scalar.
     *
     * @param int|double $scalar
     *
     * @return Matrix
     * @throws \InvalidArgumentException
     */
    public function scalarDivide($scalar)
    {
        if (!is_numeric($scalar)) {
            throw new \InvalidArgumentException('Excepted int or double but given ' . gettype($scalar));
        }
        $newMatrix = [];
        foreach ($this->mainMatrix as $i => $row) {
            foreach ($row as $j => $col) {
                $newMatrix[$i][$j] = $col / $scalar;
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Multiply every element of matrix on which this method is called by the scalar.
     *
     * @param int|double $scalar
     *
     * @return Matrix
     * @throws \InvalidArgumentException
     */
    public function scalarMultiply($scalar)
    {
        if (!is_numeric($scalar)) {
            throw new \InvalidArgumentException('Excepted int or double but given ' . gettype($scalar));
        }
        $newMatrix = [];
        foreach ($this->mainMatrix as $i => $row) {
            foreach ($row as $j => $col) {
                $newMatrix[$i][$j] = $col * $scalar;
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Subtract matrix2 from matrix object on which this method is called
     *
     * @param Matrix $matrix2
     *
     * @return Matrix Note that original matrix is left unchanged
     * @throws \DomainException
     * @throws \InvalidArgumentException
     */
    public function subtract(Matrix $matrix2)
    {
        if (($this->rows !== $matrix2->numRows()) || ($this->columns !== $matrix2->numColumns())) {
            throw new \DomainException('Matrices are not the same size!');
        }
        $newMatrix = [];
        foreach ($this->mainMatrix as $i => $row) {
            foreach ($row as $j => $column) {
                $newMatrix[$i][$j] = $column - $matrix2->getElementAt($i, $j);
            }
        }
        return new Matrix($newMatrix);
    }
    /**
     * Compute the transpose of matrix on which this method is called (invert rows and columns).
     *
     * @return Matrix Original Matrix is not affected.
     * @throws \InvalidArgumentException
     */
    public function transpose()
    {
        $newArray = [];
        foreach ($this->mainMatrix as $i => $row) {
            foreach ($row as $j => $col) {
                $newArray[$j][$i] = $col;
            }
        }
        return new Matrix($newArray);
    }
    /**
     * @var int $columns Num of columns in matrix.
     */
    protected $columns;
    /**
     * @var array $mainMatrix Holds the actual matrix structure.
     */
    protected $mainMatrix;
    /**
     * @var int $rows Num of rows in matrix.
     */
    protected $rows;
}

class Lib_Regression{
    /**
     *
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @throws \RangeException
     */
    public function compute()
    {
		echo "x = ".count($this->getX())."<br>";
		echo "y = ".count($this->getY())."<br>";
		exit;
        if (0 === count($this->getX()) || 0 === count($this->getY())) {
            throw new \LogicException('Please supply valid X and Y arrays');
        }
        $this->observations = count($this->getX());
        $mx = new Matrix($this->getX());
        $my = new Matrix($this->getY());
        //coefficient(b) = (X'X)-1X'Y
        $xTx = $mx->transpose()
                  ->multiply($mx)
                  ->inverse();
        $xTy = $mx->transpose()
                  ->multiply($my);
        $coeff = $xTx->multiply($xTy);
        //note: intercept is included
        $num_independent = $mx->numColumns();
        $sample_size = $mx->numRows();
        $dfTotal = $sample_size - 1;
        $dfModel = $num_independent - 1;
        $dfResidual = $dfTotal - $dfModel;
        //create unit vector..
        $um = new Matrix(array_fill(0, $sample_size, [1]));
        //SSR = b(t)X(t)Y - (Y(t)UU(T)Y)/n
        //MSE = SSE/(df)
        $SSR = $coeff->transpose()
                     ->multiply($mx->transpose())
                     ->multiply($my)
                     ->subtract(
                         $my->transpose()
                            ->multiply($um)
                            ->multiply($um->transpose())
                            ->multiply($my)
                            ->scalarDivide($sample_size)
                     );
        $SSE = $my->transpose()
                  ->multiply($my)
                  ->subtract(
                      $coeff->transpose()
                            ->multiply($mx->transpose())
                            ->multiply($my)
                  );
        $SSTO = $SSR->add($SSE);
        $this->SSEScalar = $SSE->getElementAt(0, 0);
        $this->SSRScalar = $SSR->getElementAt(0, 0);
        $this->SSTOScalar = $SSTO->getElementAt(0, 0);
        $this->rSquare = $this->SSRScalar / $this->SSTOScalar;
        $this->multipleR = sqrt($this->getRSquare());
        $this->f = (($this->SSRScalar / $dfModel) / ($this->SSEScalar / $dfResidual));
        $MSE = $SSE->scalarDivide($dfResidual);
        //this is a scalar.. get element
        $e = $MSE->getElementAt(0, 0);
        $stdErr = $xTx->scalarMultiply($e);
        $seArray = [];
        $tStat = [];
        $pValue = [];
        /** @noinspection ForeachInvariantsInspection */
        for ($i = 0; $i < $num_independent; $i++) {
            //get the diagonal elements
            $seArray[] = [sqrt($stdErr->getElementAt($i, $i))];
            //compute the t-statistic
            $tStat[] = [$coeff->getElementAt($i, 0) / $seArray[$i][0]];
            //compute the student p-value from the t-stat
            $pValue[] = [$this->student_PValue($tStat[$i][0], $dfResidual)];
        }
        //convert into 1-d vectors and store
        /** @noinspection ForeachInvariantsInspection */
        for ($ctr = 0; $ctr < $num_independent; $ctr++) {
            $this->coefficients[] = $coeff->getElementAt($ctr, 0);
            $this->stdErrors[] = $seArray[$ctr][0];
            $this->tStats[] = $tStat[$ctr][0];
            $this->pValues[] = $pValue[$ctr][0];
        }
    }
    /**
     * @return array
     */
    public function getCoefficients()
    {
        return $this->coefficients;
    }
    /**
     * @return int|float
     */
    public function getF()
    {
        return $this->f;
    }
    /**
     * @return float|int
     */
    public function getMultipleR()
    {
        return $this->multipleR;
    }
    /**
     * @return int
     */
    public function getObservations()
    {
        return $this->observations;
    }
    /**
     * @return array
     */
    public function getPValues()
    {
        return $this->pValues;
    }
    /**
     * @return float|int
     */
    public function getRSquare()
    {
        return $this->rSquare;
    }
    /**
     * @return float|int
     */
    public function getSSEScalar()
    {
        return $this->SSEScalar;
    }
    /**
     * @return float|int
     */
    public function getSSRScalar()
    {
        return $this->SSRScalar;
    }
    /**
     * @return float|int
     */
    public function getSSTOScalar()
    {
        return $this->SSTOScalar;
    }
    /**
     * @return array
     */
    public function getStdErrors()
    {
        return $this->stdErrors;
    }
    /**
     * @return array
     */
    public function getTStats()
    {
        return $this->tStats;
    }
    /**
     * @return array
     */
    public function getX()
    {
        return $this->x;
    }
    /**
     * @return array
     */
    public function getY()
    {
        return $this->y;
    }
    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @example  $reg->loadCSV('abc.csv',array(0), array(1,2,3));
     *
     * @param string $file
     * @param array  $dependentVariableColumn
     * @param array  $independentVariableColumns
     * @param bool   $hasHeader
     *
     * @throws \InvalidArgumentException
     */
    public function loadCSV(
        $file,
        array $dependentVariableColumn,
        array $independentVariableColumns,
        $hasHeader = true
    ) {
        $xArray = [];
        $yArray = [];
        $rawData = [];
        $handle = fopen($file, 'rb');
        if (false === $handle) {
            throw new \InvalidArgumentException('Could not open CSV file ' . $file);
        }
        //if first row has headers.. skip the first row
        if ($hasHeader && !feof($handle)) {
            fgetcsv($handle);
        }
        //get the remaining data into an array
        while (false !== ($data = fgetcsv($handle))) {
            $rawData[] = $data;
        }
        fclose($handle);
        $sampleSize = count($rawData);  //total number of rows
        if (0 === $sampleSize) {
            throw new \InvalidArgumentException('Received empty CSV file ' . $file);
        }
        for ($i = 0; $i < $sampleSize; ++$i) {
            $xArray[] = $this->getXArray($rawData, $independentVariableColumns, $i);
            //y always has 1 col!
            $yArray[] = $this->getYArray($rawData, $dependentVariableColumn, $i);
        }
        $this->setX($xArray);
        $this->setY($yArray);
    }
    /**
     * @param array $x
     *
     * @throws \InvalidArgumentException
     */
    public function setX(array $x)
    {
        if (0 === count($x)) {
            throw new \InvalidArgumentException('X can not but empty');
        }
        $this->x = $x;
    }
    /**
     * @param array $y
     *
     * @throws \InvalidArgumentException
     */
    public function setY(array $y)
    {
        if (0 === count($y)) {
            throw new \InvalidArgumentException('Y can not but empty');
        }
        $this->y = $y;
    }
    /**
     * @param array $rawData
     * @param array $colsToExtract
     * @param int   $row
     *
     * @return array
     */
    private function getXArray(array $rawData, array $colsToExtract, $row)
    {
        $returnArray = [1];
        foreach ($colsToExtract as $key => $val) {
            $returnArray[] = $rawData[$row][$val];
        }
        return $returnArray;
    }
    /**
     * @param array $rawData
     * @param array $colsToExtract
     * @param int   $row
     *
     * @return array
     */
    private function getYArray(array $rawData, array $colsToExtract, $row)
    {
        $returnArray = [];
        foreach ($colsToExtract as $key => $val) {
            $returnArray[] = $rawData[$row][$val];
        }
        return $returnArray;
    }
    /**
     * @link http://home.ubalt.edu/ntsbarsh/Business-stat/otherapplets/pvalues.htm#rtdist
     *
     * @param float $t_stat
     * @param float $deg_F
     *
     * @return float
     */
    private function student_PValue($t_stat, $deg_F)
    {
        $t_stat = (float)abs($t_stat);
        $mw = $t_stat / sqrt($deg_F);
        $th = atan2($mw, 1);
        if ($deg_F === 1.0) {
            return 1.0 - $th / (M_PI / 2.0);
        }
        $sth = sin($th);
        $cth = cos($th);
        if ($deg_F % 2 === 1) {
            return 1.0 - ($th + $sth * $cth * $this->statCom($cth * $cth, 2, $deg_F - 3, -1)) / (M_PI / 2.0);
        } else {
            return 1.0 - ($sth * $this->statCom($cth * $cth, 1, $deg_F - 3, -1));
        }
    }
    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @link http://home.ubalt.edu/ntsbarsh/Business-stat/otherapplets/pvalues.htm#rtdist
     *
     * @param float $q
     * @param float $i
     * @param float $j
     * @param float $b
     *
     * @return float
     */
    private function statCom($q, $i, $j, $b)
    {
        $zz = 1;
        $z = $zz;
        $k = $i;
        while ($k <= $j) {
            $zz = $zz * $q * $k / ($k - $b);
            $z += $zz;
            $k += 2;
        }
        return $z;
    }
    /**
     * @var int|float $f F statistic.
     */
    private $f;
    /**
     * @var int|float $rSquare R Square.
     */
    private $rSquare;
    /**
     * @var int|double $SSEScalar Sum of squares due to error.
     */
    private $SSEScalar;
    /**
     * @var int|double $SSRScalar Sum of squares due to regression.
     */
    private $SSRScalar;
    /**
     * @var int|double $SSTOScalar Total sum of squares.
     */
    private $SSTOScalar;
    /**
     * @var array $coefficients Regression coefficients array.
     */
    private $coefficients;
    /**
     * @var int|float $multipleR Multiple R.
     */
    private $multipleR;
    /**
     * @var int $observations observations.
     */
    private $observations;
    /**
     * @var array $pValues p values array.
     */
    private $pValues;
    /**
     * @var array $stdErrors Standard error array.
     */
    private $stdErrors;
    /**
     * @var array $tStats t statistics array.
     */
    private $tStats;
    /**
     * @var array $x
     */
    private $x = [];
    /**
     * @var array $y
     */
    private $y = [];
}


$x = array(
		array(66.7,62.5,83.3,87.5,62.5),array(50,75,91.7,37.5,75),array(91.7,75,75,100,75),array(58.3,62.5,91.7,62.5,37.5),array(50,54.2,41.7,50,50),array(58.3,62.5,66.7,87.5,50),array(75,95.8,58.3,62.5,62.5),array(25,54.2,66.7,62.5,62.5),array(50,54.2,58.3,75,0),array(41.7,70.8,50,75,37.5),array(50,62.5,50,50,37.5),array(58.3,62.5,50,62.5,62.5),array(75,33.3,50,50,50),array(58.3,25,58.3,12.5,0),array(16.7,20.8,25,37.5,12.5),array(58.3,50,75,50,37.5),array(25,50,83.3,25,0),array(58.3,54.2,75,62.5,25),array(41.7,50,58.3,62.5,50),array(50,70.8,66.7,75,50),array(41.7,45.8,66.7,62.5,0),array(50,54.2,50,75,37.5),array(58.3,58.3,75,62.5,50),array(41.7,33.3,66.7,50,25),array(58.3,45.8,41.7,62.5,25),array(83.3,41.7,50,62.5,12.5),array(58.3,75,75,75,0),array(33.3,50,50,75,25),array(66.7,75,91.7,75,50),array(58.3,70.8,75,50,25),array(33.3,66.7,50,50,62.5),array(33.3,62.5,66.7,62.5,75),array(75,58.3,66.7,75,50),array(33.3,54.2,66.7,75,50),array(75,58.3,75,62.5,50),array(50,66.7,66.7,75,50),array(75,54.2,41.7,50,25),array(66.7,70.8,75,50,0),array(41.7,50,50,50,50),array(66.7,33.3,41.7,25,25),array(50,83.3,50,62.5,62.5),array(50,45.8,66.7,62.5,37.5),array(33.3,50,33.3,37.5,37.5),array(41.7,45.8,50,50,25),array(25,37.5,58.3,62.5,25),array(16.7,66.7,83.3,62.5,25),array(50,54.2,58.3,62.5,75),array(50,25,50,37.5,0),array(33.3,66.7,58.3,62.5,50),array(83.3,87.5,83.3,75,75),array(75,58.3,58.3,50,75),array(58.3,50,75,50,37.5),array(41.7,70.8,75,75,25),array(41.7,33.3,58.3,37.5,25),array(58.3,58.3,66.7,50,50),array(66.7,37.5,58.3,50,25),array(58.3,33.3,75,62.5,37.5),array(66.7,50,41.7,50,62.5),array(41.7,37.5,58.3,50,37.5),array(25,62.5,33.3,75,25),array(91.7,70.8,83.3,62.5,62.5),array(41.7,33.3,50,62.5,12.5),array(50,33.3,58.3,25,25),array(16.7,50,66.7,75,25),array(66.7,54.2,83.3,62.5,50),array(66.7,29.2,91.7,75,62.5),array(66.7,0,66.7,62.5,0),array(58.3,91.7,66.7,75,25),array(83.3,62.5,66.7,100,75),array(83.3,70.8,75,75,75),array(50,54.2,50,62.5,37.5),array(50,29.2,33.3,12.5,50),array(50,62.5,66.7,75,25),array(41.7,50,58.3,50,25),array(50,87.5,75,87.5,62.5),array(58.3,66.7,58.3,75,37.5),array(100,75,50,62.5,75),array(83.3,54.2,58.3,75,50),array(33.3,54.2,58.3,62.5,50),array(66.7,62.5,41.7,75,25),array(41.7,54.2,50,75,0),array(41.7,58.3,58.3,50,62.5),array(75,70.8,58.3,62.5,25),array(50,58.3,50,75,50),array(66.7,58.3,58.3,62.5,37.5),array(66.7,75,75,75,25),array(58.3,29.2,50,25,37.5),array(41.7,45.8,58.3,75,62.5),array(33.3,54.2,58.3,75,37.5),array(41.7,54.2,50,75,0),array(58.3,62.5,66.7,75,25),array(50,29.2,25,50,75),array(83.3,54.2,75,87.5,62.5),array(25,45.8,41.7,37.5,0),array(41.7,75,66.7,50,37.5),array(33.3,54.2,50,75,37.5),array(33.3,58.3,50,62.5,25),array(50,54.2,58.3,75,25),array(33.3,54.2,50,75,87.5),array(41.7,50,58.3,75,50),array(41.7,62.5,50,75,37.5),array(50,62.5,58.3,75,50),array(75,75,58.3,75,37.5),array(58.3,83.3,58.3,87.5,75),array(66.7,66.7,75,75,62.5),array(41.7,54.2,66.7,62.5,25),array(25,0,41.7,12.5,0),array(33.3,50,50,37.5,25),array(33.3,66.7,83.3,75,25),array(66.7,75,66.7,75,50),array(50,66.7,66.7,75,37.5),array(50,75,75,75,50),array(58.3,62.5,50,75,75),array(25,62.5,58.3,62.5,75),array(33.3,50,41.7,62.5,25),array(41.7,66.7,58.3,75,25),array(75,62.5,41.7,87.5,37.5),array(50,87.5,83.3,100,75),array(41.7,45.8,50,75,62.5),array(58.3,83.3,83.3,75,37.5),array(75,58.3,66.7,75,50),array(41.7,62.5,58.3,75,37.5),array(58.3,54.2,41.7,75,25),array(75,66.7,75,75,87.5),array(41.7,12.5,41.7,37.5,25),array(33.3,50,50,50,50),array(66.7,83.3,66.7,100,50),array(33.3,50,66.7,50,25),array(66.7,58.3,83.3,87.5,37.5),array(83.3,87.5,75,100,100),array(66.7,58.3,83.3,87.5,37.5),array(83.3,91.7,100,87.5,100),array(50,33.3,50,37.5,25),array(50,70.8,58.3,62.5,50),array(50,45.8,50,62.5,37.5),array(66.7,58.3,58.3,50,62.5),array(41.7,33.3,41.7,50,37.5),array(66.7,58.3,58.3,50,62.5),array(41.7,33.3,41.7,50,37.5),array(50,45.8,50,62.5,37.5),array(50,70.8,58.3,62.5,50),array(50,33.3,50,37.5,25),array(83.3,91.7,100,87.5,100),array(50,70.8,58.3,62.5,50),array(50,33.3,50,37.5,25),array(16.7,8.3,25,37.5,0),array(50,54.2,66.7,50,50),array(50,54.2,50,50,50),array(58.3,66.7,50,50,25),array(41.7,33.3,58.3,50,37.5),array(41.7,33.3,58.3,50,37.5),array(50,54.2,50,50,50),array(58.3,66.7,50,50,25),array(50,54.2,66.7,50,50),array(16.7,8.3,25,37.5,0),array(41.7,33.3,58.3,50,37.5),array(50,54.2,66.7,50,50),array(50,70.8,33.3,25,75),array(50,45.8,50,50,75),array(41.7,41.7,50,37.5,37.5),array(41.7,41.7,50,37.5,37.5),array(50,45.8,50,50,75),array(50,70.8,33.3,25,75),array(41.7,41.7,50,37.5,37.5),array(50,45.8,50,50,75),array(50,70.8,33.3,25,75),array(50,41.7,41.7,50,25),array(50,41.7,41.7,50,25),array(50,41.7,41.7,50,25),array(66.7,45.8,58.3,50,25),array(66.7,45.8,58.3,50,25),array(66.7,45.8,58.3,50,25),array(41.7,50,58.3,50,37.5),array(50,37.5,50,25,37.5),array(66.7,66.7,66.7,62.5,75),array(41.7,33.3,58.3,75,25),array(33.3,62.5,50,62.5,50),array(50,50,50,50,50),array(66.7,62.5,66.7,75,37.5),array(66.7,62.5,50,75,50),array(66.7,62.5,50,75,50),array(66.7,62.5,66.7,75,37.5),array(50,50,50,50,50),array(33.3,62.5,50,62.5,50),array(41.7,33.3,58.3,75,25),array(66.7,66.7,66.7,62.5,75),array(50,37.5,50,25,37.5),array(41.7,50,58.3,50,37.5),array(66.7,62.5,66.7,75,37.5),array(50,37.5,50,25,37.5),array(41.7,50,58.3,50,37.5),array(75,75,75,75,62.5),array(41.7,66.7,75,50,37.5),array(16.7,83.3,83.3,100,50),array(75,62.5,16.7,25,37.5),array(66.7,41.7,75,50,50),array(8.3,37.5,50,62.5,0),array(58.3,54.2,50,37.5,62.5),array(50,58.3,75,75,50),array(66.7,37.5,75,62.5,25),array(25,41.7,50,37.5,25),array(50,70.8,50,75,50),array(33.3,54.2,58.3,50,50),array(41.7,37.5,66.7,37.5,50),array(75,62.5,58.3,75,37.5),array(58.3,45.8,50,62.5,62.5),array(50,54.2,41.7,50,37.5),array(58.3,66.7,41.7,62.5,62.5),array(66.7,58.3,58.3,62.5,25),array(75,75,66.7,62.5,50),array(50,66.7,58.3,62.5,0),array(33.3,45.8,50,62.5,37.5),array(41.7,33.3,33.3,50,50),array(58.3,62.5,66.7,62.5,62.5),array(50,58.3,41.7,62.5,25),array(41.7,33.3,58.3,62.5,50),array(50,54.2,58.3,62.5,37.5),array(66.7,41.7,41.7,50,25),array(66.7,58.3,50,75,75),array(33.3,33.3,58.3,37.5,37.5),array(66.7,91.7,83.3,87.5,62.5),array(41.7,29.2,50,37.5,25),array(33.3,54.2,50,62.5,50),array(83.3,41.7,41.7,50,62.5),array(33.3,45.8,41.7,75,37.5),array(58.3,41.7,41.7,37.5,37.5),array(41.7,54.2,75,50,50),array(25,25,58.3,25,25),array(66.7,70.8,41.7,50,25),array(50,50,66.7,62.5,50),array(58.3,66.7,66.7,62.5,37.5),array(66.7,87.5,75,75,62.5),array(58.3,87.5,75,87.5,50),array(91.7,58.3,91.7,75,75),array(25,50,50,62.5,0),array(58.3,62.5,41.7,50,37.5),array(58.3,58.3,50,75,37.5),array(0,0,16.7,12.5,50),array(50,54.2,58.3,62.5,25),array(50,62.5,50,75,50),array(66.7,54.2,58.3,50,50),array(50,50,58.3,50,50),array(58.3,58.3,66.7,62.5,37.5),array(33.3,37.5,50,62.5,37.5),array(50,83.3,91.7,87.5,75),array(41.7,29.2,75,12.5,62.5),array(16.7,37.5,66.7,75,25),array(41.7,25,25,25,75),array(50,70.8,41.7,75,37.5),array(33.3,33.3,58.3,0,12.5),

        );
//dependent variables
 $y = array(
		array(90),array(65),array(75),array(25),array(65),array(65),array(60),array(70),array(25),array(75),array(55),array(55),array(70),array(55),array(35),array(65),array(75),array(70),array(55),array(75),array(70),array(60),array(65),array(25),array(45),array(40),array(60),array(20),array(75),array(50),array(45),array(55),array(55),array(60),array(75),array(80),array(55),array(90),array(50),array(90),array(75),array(45),array(40),array(45),array(55),array(80),array(50),array(30),array(70),array(100),array(45),array(65),array(55),array(70),array(65),array(65),array(55),array(65),array(50),array(65),array(55),array(45),array(50),array(35),array(60),array(100),array(50),array(60),array(65),array(60),array(55),array(25),array(50),array(50),array(70),array(55),array(90),array(75),array(45),array(55),array(55),array(50),array(55),array(65),array(60),array(50),array(70),array(55),array(60),array(25),array(65),array(30),array(90),array(25),array(50),array(55),array(55),array(50),array(50),array(65),array(50),array(50),array(60),array(80),array(65),array(30),array(55),array(35),array(55),array(85),array(70),array(75),array(70),array(60),array(50),array(65),array(75),array(85),array(45),array(85),array(60),array(70),array(50),array(80),array(45),array(50),array(100),array(65),array(65),array(70),array(65),array(75),array(70),array(45),array(45),array(55),array(35),array(55),array(35),array(45),array(45),array(70),array(75),array(45),array(70),array(10),array(50),array(50),array(55),array(40),array(40),array(50),array(55),array(50),array(10),array(40),array(50),array(100),array(70),array(45),array(45),array(70),array(100),array(45),array(70),array(100),array(50),array(50),array(50),array(25),array(25),array(25),array(60),array(55),array(80),array(65),array(65),array(50),array(65),array(75),array(75),array(65),array(50),array(65),array(65),array(80),array(55),array(60),array(65),array(55),array(60),array(65),array(85),array(30),array(50),array(65),array(75),array(50),array(70),array(45),array(25),array(55),array(30),array(55),array(50),array(50),array(55),array(50),array(55),array(55),array(45),array(50),array(45),array(65),array(50),array(40),array(50),array(40),array(60),array(40),array(75),array(25),array(50),array(50),array(55),array(45),array(45),array(40),array(35),array(60),array(60),array(75),array(75),array(70),array(50),array(50),array(85),array(45),array(60),array(60),array(50),array(50),array(65),array(50),array(90),array(50),array(55),array(50),array(65),array(25),
	  );
 
$reg = new Lib_Regression();
$reg->setX($x);
$reg->setY($y);
 
//NOTE: passing true to the compute method generates standardized coefficients
$reg->Compute();    //go!
 
/*var_dump($reg->getSSE());
var_dump($reg->getSSR());
var_dump($reg->getSSTO());
var_dump($reg->getRSQUARE());
var_dump($reg->getF());
var_dump($reg->getRSQUAREPValue());
var_dump($reg->getCoefficients());
var_dump($reg->getStandardError());*/
echo "abcde <br>";
var_dump($reg->getTStats());
//var_dump($reg->getPValues());
?>