<?php 

define('PLUMBER', 1);

class BusinessInfo
{
    public $category = null;
    public $total_served = 0;
    public $gross_revenue = 0;
    public $rating = 0;
    public $bid = 0;

    public function __construct($bid, $cat, $total, $gross, $rate)
    {
        $this->category = $cat;
        $this->total_served = $total;
        $this->gross_revenue = $gross;
        $this->rating = $rate;
        $this->bid = $bid;
    }
}
?>