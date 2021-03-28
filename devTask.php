<?php
// /////////////////////////////////////////////////////////////////////////////
// PREDEFINED CONSTANTS, INTERFACES AND CLASSES
// /////////////////////////////////////////////////////////////////////////////

define("PI", 3.14);

/**
 * Interface defining methods for all shapes.
 */
interface ShapeInterface
{
    public function getPerimeter();
    public function getArea();
}


/**
 * Interface defining methods for polygon shapes.
 */
interface PolygonInterface
{
    public function getAngles();
}

/**
 * Base class for geometry objects.
 */
class GeometryShape
{
    public function getName()
    {
        return get_class($this);
    }
}

// /////////////////////////////////////////////////////////////////////////////
// WORKING AREA
// THIS IS AN AREAD WHERE YOU SHOULD WRITE YOUR CODE AND MAKE CHANGES.
// /////////////////////////////////////////////////////////////////////////////

/**
 * Factory class for creating different GeometryShapes.
 */
class ShapeFactory
{

    /**
    * Creates a specific GeometryShape object from the given attributes.
    *
    * Usage examples:
    *     ShapeFactory::createShape("Circle", 4)
    *     ShapeFactory::createShape("Rectangle", [3, 5])
    *
    * @param string shape Shape to create.
    * @param array params Array of needed parameters.
    */
    public static function createShape($shape, $params)
    {
        return new $shape($params);
    }
}


class Rectangle extends GeometryShape implements ShapeInterface, PolygonInterface
{
    protected $height;
    protected $width;

    public function __construct($params)
    {
        $this->height = $params[0];
        $this->width = $params[1];
    }

    public function getPerimeter()
    {
        return (($this->height + $this->width) * 2);
    }

    public function getArea()
    {
        return ($this->width * $this->height);
    }

    public function getAngles()
    {
        return 4;
    }
}

class Circle extends GeometryShape implements ShapeInterface
{
    protected $diameter;

    public function __construct($diameter)
    {
        $this->diameter = $diameter[0];
    }

    public function getPerimeter()
    {
        return  (2 * PI * $this->diameter);
    }

    public function getArea()
    {
        return (pow($this->diameter, 2) * PI);
    }
}


// /////////////////////////////////////////////////////////////////////////////
// TEST CODE
// THE CODE BELOW IS READ ONLY CODE AND YOU SHOULD INSPECT IT TO SEE WHAT IT
// DOES IN ORDER TO COMPLETE THE TASK, BUT DO NOT MODIFY IT IN ANY WAY
// AS THAT WILL RESULT IN A TEST FAILURE
// /////////////////////////////////////////////////////////////////////////////

/**
 * Helper function which is used to create shape based on input parameters
 * and return information about that specific shape.
 */
function getInfo($shape, $params)
{
    try {
        $shapeObject = ShapeFactory::createShape($shape, $params);

        $info = $shapeObject->getName() . PHP_EOL;
        if ($shapeObject instanceof ShapeInterface) {
            $info .= "Perimeter is: " . number_format($shapeObject->getPerimeter(), 2) . PHP_EOL;
            $info .= "Area is: " . number_format($shapeObject->getArea(), 2) . PHP_EOL;
        }
        if ($shapeObject instanceof PolygonInterface) {
            $info .= "Number of angles: " . $shapeObject->getAngles() . PHP_EOL;
        }
        $info .= PHP_EOL;

        return $info;
    } catch (UnsuportedShapeException $e) {
        return "Unsupported Shape" . PHP_EOL;
    } catch (WrongParamCountException $e) {
        return "Wrong Number Of Shape Params" . PHP_EOL;
    }
}
error_reporting(0);

// while($f = fgets(STDIN)){
$file = fopen('shapesData.txt', "r");

while ($f = fgets($file)) {
    $params = explode(" ", $f);
    $shape = $params[0];
    $shapeParams = explode(",", $params[1]);
    echo getInfo($shape, $shapeParams)."<br/>";
}