<?php 
namespace Model;

class BusinessProfile
{
    public function __construct($bid, $name, $bimage, $bloc, $blatlong, $uid)
    {
        $this->b_profile_id = $bid;
        $this->b_profile_name = $name;
        $this->b_profile_image = $bimage;
        $this->b_profile_location = $bloc;
        $this->b_profile_latlong = $blatlong;
        $this->u_id = $uid;
    }
}
?>