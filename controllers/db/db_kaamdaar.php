<?php 
	require_once "db_controller.php";
	require_once "/opt/lampp/htdocs/kaamdaar/models/user.php";
	require_once "kaamdaar_db_constants.php";

	final class KaamdaarDBHandler extends MySQLDBHandler
	{
		public function __construct()
		{
			parent::__construct(
				DB_HOST,
				DB_USERNAME,
				DB_PASSWORD,
				DB_NAME,
				false
			);
		}

		public function addUser(User $user) : bool
		{
			$format = "ssssssss";

			$field_names = [
				'u_fname', 
				'u_lname', 
				'u_phone',
				'u_password',
				'u_gender',
				'u_date', 
				'u_location',
				'u_loc_latlong'
			];

			$field_values = [
				$user->fname, 
				$user->lname, 
				$user->phone, 
				$user->password, 
				$user->gender, 
				$user->dateJoined, 
				$user->location,
				$user->locLatLong
			];

			return $this->insertIntoTable(USER_TABLE, $field_names, $field_values, $format);
		}

		private function getUser(?string $field_name, $check_value) : User|null
		{
			if(!$field_name || !$check_value) return null;

			$user = null;
			$rows = $this->fetchTableWhere(USER_TABLE, ["$field_name=$check_value"]);
			if($rows && count($rows))
			{
				$row = $rows[0];
				$user = new User(
					$row->getField('u_id'),
					$row->getField('u_fname'),
					$row->getField('u_lname'),
					$row->getField('u_phone'),
					$row->getField('u_password'),
					$row->getField('u_gender'),
					$row->getField('u_date'),
					$row->getField('u_location'),
					$row->getField('u_loc_latlong')
				);
			}
			return $user;
		}

		public function getUserWithID(?int $uid) : User|null
		{
			return $this->getUser("u_id", $uid);
		}

		public function getUserWithPhone(?string $phone) : User|null
		{
			return $this->getUser("u_phone", $phone);
		}

		public function removeUser(?int $uid) : bool
		{
			if(!$uid) return false;
			return $this->removeFromTableWhere(USER_TABLE, ["u_id=$uid"]);
		}

		public function __toString()
		{
			return $this->database;
		}
	}

?>