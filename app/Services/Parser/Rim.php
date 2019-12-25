<?php

namespace App\Services\Parser;

class Rim
{
    /**
     * Passenger car tires
     * https://en.wikipedia.org/wiki/Tire_code
     *
     * E.g. 225/55 R17 101V S954 TL XL
     * @var string
     */
    protected $code;
    /**
     * Passenger car tire code string e.g. 225/55 R17 101V S954 TL XL
     * TODO: Validate for acceptable characters only
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = trim($code);
        return $this;
    }
    public function getTireCode()
    {
        return $this->code;
    }
    
    /**
     * @return mixed
     */
    public function getWidth()
    {
        $expl = explode(' ', $this->code);
        return (float)$expl[0];
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        $expl = explode(' ', $this->code);
        return preg_replace('/[^0-9]/', '', $expl[1]);
    }
}