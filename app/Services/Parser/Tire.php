<?php

namespace App\Services\Parser;

class Tire
{
    /**
     * Passenger car tires
     * https://en.wikipedia.org/wiki/Tire_code
     *
     * E.g. 225/55 R17 101V S954 TL XL
     * @var string
     */
    protected $tire_code;
    /**
     * Passenger car tire code string e.g. 225/55 R17 101V S954 TL XL
     * TODO: Validate for acceptable characters only
     * @param string $tire_code
     */
    public function __construct($tire_code)
    {
        $this->tire_code = trim($tire_code);
        return $this;
    }
    public function getTireCode()
    {
        return $this->tire_code;
    }
    /**
     * 3-digit number: The "nominal section width" of the tire in millimeters;
     * the widest point from both outer edges (side wall to side wall).
     * @return mixed
     */
    public function getWidth()
    {
        if (preg_match("/^([0-9]+)\/[0-9]+/", $this->tire_code, $matches)) {  // Check if begins with "225"
            return $matches[1];
        }
    }
    /**
     * 2- or 3-digit number: The "aspect ratio" of the sidewall height as a
     * percentage of the nominal section width of the tire.
     * @return mixed
     */
    public function getAspectRatio()
    {
        if (preg_match("/^[0-9]+\/([0-9]+)/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }
    public function getTireSize()
    {
        if (preg_match("/^([0-9]+\/[0-9]+)/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }
    public function getSpeedRating()
    {
        $tire_size = str_replace(' ', '', $this->tire_code); // Strip spaces e.g. 225/55 Z R78 -> 225/55R17
        if (preg_match("/^.*ZR.*/", $tire_size)) {
            return 'ZR';
        } else {
            return 'R';
        }
    }
    /**
     * 1- or 2-digit number: Diameter in inches of the wheel that the tires are
     * designed to fit.
     * @return mixed
     */
    public function getRimDiameter()
    {
        if (preg_match("/^[0-9]+\/[0-9]+\s*[{R,ZR}]+\s*([0-9]{2})/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }
    /**
     * 2- or 3-digit number: Load index. The load index on a passenger-car tire
     * is a numerical code stipulating the maximum load (mass, or weight) each
     * tire can carry.
     * @return mixed
     */
    public function getLoadIndex()
    {
        $load_index_speed_symbol = $this->getLoadIndexSpeedSymbol();
        if ($load_index_speed_symbol) {
            return str_replace(array('Q', 'R', 'S', 'T', 'H', 'V', 'W', 'Y', '(', ')'), '', $load_index_speed_symbol);
        }
    }
    /**
     * Combined LoadIndex and SpeedSymbol.
     * @return mixed
     */
    public function getLoadIndexSpeedSymbol()
    {
        $pattern = "/^[0-9]+\/[0-9]+\s*[{R,ZR}]+\s*[0-9]{2}\s*(\(?[0-9]{2,3}[QRSTHVWY]\)?)/";
        if (preg_match($pattern, $this->tire_code, $matches)) {
            return $matches[1];
        }
    }
    /**
     * The speed symbol is made up of a single letter optionally enclosed
     * in brackets - Q, R, S, T, H, V, W, Y, (Y).
     * @return mixed
     */
    public function getSpeedSymbol()
    {
        $load_index_speed_symbol = $this->getLoadIndexSpeedSymbol();
        if ($load_index_speed_symbol) {
            return str_replace(range(0, 9), '', $load_index_speed_symbol);
        }
    }
}