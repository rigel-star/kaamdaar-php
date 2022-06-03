<?php
    require_once "../constants.php";
    require_once ROOT_DIR . "models/user.php";
    require_once ROOT_DIR . "models/business-profile.php";
    require_once ROOT_DIR . "models/business.php";

    use Model\{User, Business, BusinessProfile};

    class ResultSet implements Iterator, Countable
    {
        private $items = [];
        private $pointer = 0;
        private $itemsCount = 0;

        public function __construct($result)
        {
            if(!($result instanceof mysqli_result))
                return;

            while($row = $result->fetch_assoc())
                array_push($this->items, $row);

            $this->itemsCount = count($this->items);
        }

        public function current() {
            return $this->items[$this->pointer];
        }
    
        public function key() {
            return $this->pointer;
        }
    
        public function next() {
            $this->pointer++;
        }

        public function rewind() {
            $this->pointer = 0;
        }
    
        public function valid() {
            return $this->pointer < count($this->items);
        }

        public function count()
        {
            return $this->itemsCount;
        }
    }

    class KaamdaarORM
    {
        public $connection = null;
        public function __construct()
        {
            $this->connection = new mysqli("localhost", "root", "", "kaamdaar");
            if($this->connection->connect_error)
            {
                echo "Failed to connect to MySQL database: " . $this->connection->connect_error;
                exit();
            }

            $this->connection->autocommit(false);
        }

        public function close()
        {
            $this->connection->close();
        }

        public function from(string $table)
        {
            $this->current_table = $table;
            return $this;
        }

        public function fetch(?array $attrs, ?array $where_clauses)
        {
            if($this->current_table === "")
            {
                echo "Choose a table using 'from()' first.";
                return null;
            }

            $SQL = "SELECT ";
            if($attrs && count($attrs))
                $SQL .= implode(",", $attrs);
            else $SQL .= "*";

            $SQL .= " FROM $this->current_table";
            $this->current_table = "";

            if($where_clauses && count($where_clauses))
            {
                $SQL .= " WHERE " . implode(" and ", $this->array_map_assoc(
                    function($key, $value) {
                        return "$key=$value";
                    }, 
                $where_clauses));
            }
            $SQL .= ";";

            if($result = $this->connection->query($SQL))
                return new ResultSet($result);
            else 
                return null;
        }

        public function fetchAll()
        {
            return $this->fetch(null, null);
        }

        private function array_map_assoc($func, array $arr)
        {
            $result = array();
            foreach($arr as $key => $value)
            {
                array_push($result, $func($key, $value));
            }
            return $result;
        }

        public function getUserByID($uid)
        {
            $user = null;
            $result_set = $this->from("users")->fetch(null, ["U_ID" => $uid]);
            if($result_set)
            {
                $row = $result_set->current();
                $user = new User(
                    $row['U_ID'],
                    $row["U_FNAME"],
                    $row["U_LNAME"],
                    $row["U_PHONE"],
                    $row["U_PASSWORD"],
                    $row["U_GENDER"],
                    $row["U_DATE"],
                    $row["U_LOCATION"],
                    $row["U_LATLONG"]
                );
            }
            return $user;
        }

        public function getUserByPhone($phone)
        {
            $user = null;
            $result_set = $this->from("users")->fetch(null, ["U_PHONE" => $phone]);
            if($result_set)
            {
                $row = $result_set->current();
                $user = new User(
                    $row['U_ID'],
                    $row["U_FNAME"],
                    $row["U_LNAME"],
                    $row["U_PHONE"],
                    $row["U_PASSWORD"],
                    $row["U_GENDER"],
                    $row["U_DATE"],
                    $row["U_LOCATION"],
                    $row["U_LATLONG"]
                );
            }
            return $user;
        }

        public function removeUserByID($uid)
        {
            $SQL = "CALL remove_user($uid);";
            $this->connection->query($SQL);
        }

        public function getBusinessProfile($uid)
        {
            $SQL = "SELECT * FROM business_profile WHERE U_ID = $uid";
            $result = $this->connection->query($SQL);

            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $profile = new BusinessProfile(
                    $row['B_PROFILE_ID'],
                    $row['B_PROFILE_NAME'],
                    $row['B_PROFILE_IMAGE'],
                    "",
                    "",
                    $row["U_ID"]
                );
                return $profile;
            }
            return null;
        }

        public function getAllBusinessInfo($bid)
        {
            $SQL = "SELECT b.business_id AS business_id, b.b_profile_id AS business_profile_id, cat.b_cat_name AS business_type, info.b_info_revenue AS business_revenue, info.b_info_rating AS business_rating, info.b_info_total AS business_total FROM business b INNER JOIN business_category as cat on cat.b_cat_id = b.business_type INNER JOIN business_info AS info ON b.business_id = info.business_id WHERE b.b_profile_id = $bid;";
            $result_set = new ResultSet($this->connection->query($SQL));

            if(!count($result_set)) return [];
            
            $all_business = [];
            foreach($result_set as $result)
            {
                array_push($all_business, new Model\Business(
                    $result['business_id'],
                    $result['business_type'],
                    $result['business_profile_id'],
                    $result['business_revenue'],
                    $result['business_rating'],
                    $result['business_total']
                ));
            }
            return $all_business;
        }

        public function rawQuery($SQL)
        {
            return new ResultSet($this->connection->query($SQL));
        }
    }
?>