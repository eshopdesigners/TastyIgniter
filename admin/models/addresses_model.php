<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Addresses_model extends CI_Model {

	public function getCustomerAddresses($customer_id) {
		$address_data = array();

		if (is_numeric($customer_id)) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $result) {

					$address_data[$result['address_id']] = array(
						'address_id'     => $result['address_id'],
						'address_1'      => $result['address_1'],
						'address_2'      => $result['address_2'],
						'city'           => $result['city'],
						'state'          => $result['state'],
						'postcode'       => $result['postcode'],
						'country_id'     => $result['country_id'],
						'country'        => $result['country_name'],
						'iso_code_2'     => $result['iso_code_2'],
						'iso_code_3'     => $result['iso_code_3'],
						'format'		 => $result['format']
					);
				}
			}
		}

		return $address_data;
	}

	public function getGuestAddress($address_id) {
		$this->db->from('addresses');
		$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

		$this->db->where('address_id', $address_id);

		$query = $this->db->get();

		$address_data = array();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			$address_data = array(
				'address_id'     => $row['address_id'],
				'address_1'      => $row['address_1'],
				'address_2'      => $row['address_2'],
				'city'           => $row['city'],
				'state'          => $row['state'],
				'postcode'       => $row['postcode'],
				'country_id'     => $row['country_id'],
				'country'        => $row['country_name'],
				'iso_code_2'     => $row['iso_code_2'],
				'iso_code_3'     => $row['iso_code_3'],
				'format'		 => $row['format']
			);
		}

		return $address_data;
	}

	public function getCustomerAddress($customer_id, $address_id) {
		if (($customer_id !== '0') AND ($address_id !== '0')) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			$address_data = array();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$address_data = array(
					'address_id'     => $row['address_id'],
					'address_1'      => $row['address_1'],
					'address_2'      => $row['address_2'],
					'city'           => $row['city'],
					'state'          => $row['state'],
					'postcode'       => $row['postcode'],
					'country_id'     => $row['country_id'],
					'country'        => $row['country_name'],
					'iso_code_2'     => $row['iso_code_2'],
					'iso_code_3'     => $row['iso_code_3'],
					'format'     	 => $row['format']
				);
			}

			return $address_data;
		}
	}

	public function getCustomerDefaultAddress($address_id, $customer_id) {
		if (($address_id !== '0') && ($customer_id !== '0')) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function updateCustomerAddress($customer_id = FALSE, $address_id = FALSE, $address = array()) {
		$query = FALSE;

		if ($customer_id) {
			$this->db->set('customer_id', $customer_id);
		}

		if (!empty($address['address_1'])) {
			$this->db->set('address_1', $address['address_1']);
		}

		if (!empty($address['address_2'])) {
			$this->db->set('address_2', $address['address_2']);
		}

		if (!empty($address['city'])) {
			$this->db->set('city', $address['city']);
		}

		if (!empty($address['postcode'])) {
			$this->db->set('postcode', $address['postcode']);
		}

		if (!empty($address['country'])) {
			$this->db->set('country_id', $address['country']);
		}

		if ($address_id) {
			$this->db->where('address_id', $address_id);
			$query = $this->db->update('addresses');
		} else {
			if ($this->db->insert('addresses')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function updateCustomerDefaultAddress($customer_id = '', $address_id = '') {
		$query = FALSE;

		if ($address_id !== '' AND $customer_id !== '') {
			$this->db->set('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->update('customers');
		}

		return $query;
	}

	public function addCustomerAddress($customer_id, $address = array()) {
		$query = FALSE;

		if ($customer_id) {
			$this->db->set('customer_id', $customer_id);
		}

		if (!empty($address['address_1'])) {
			$this->db->set('address_1', $address['address_1']);
		}

		if (!empty($address['address_2'])) {
			$this->db->set('address_2', $address['address_2']);
		}

		if (!empty($address['city'])) {
			$this->db->set('city', $address['city']);
		}

		if (!empty($address['postcode'])) {
			$this->db->set('postcode', $address['postcode']);
		}

		if (!empty($address['country'])) {
			$this->db->set('country_id', $address['country']);
		}

		if ($this->db->insert('addresses')) {
			$query = $this->db->insert_id();
		}

		return $query;
	}

	public function deleteAddress($customer_id, $address_id) {

		$this->db->where('customer_id', $customer_id);
		$this->db->where('address_id', $address_id);

		$this->db->delete('addresses');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file addresses_model.php */
/* Location: ./admin/models/addresses_model.php */