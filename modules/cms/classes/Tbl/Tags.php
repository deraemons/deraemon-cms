<?php

defined('SYSPATH') or die('No direct script access.');

class Tbl_Tags extends Tbl {

	/**
	 * Construct
	 *
	 * @param string $name
	 */
	public function __construct()
	{
		$this->_columns = array(
			'id',
			'segment',
			'name',
			'order',
			'description',
		);

		$this->_unchangeable = array(
			'id',
		);

		parent::__construct();
	}

	/**
	 * Validate
	 *
	 * @abstract Model_Table
	 * @param array $data
	 * @return Validation
	 * @throws Validation_Exception
	 */
	public function validate($data)
	{
		$validation = Validation::factory($data)
			// rule
			->rule('segment', 'not_empty')
			->rule('segment', 'max_length', array(':value', '200'))
			->rule('segment', 'regex', array(':value', '/^[a-z0-9_]+$/'))
			->rule('segment', array($this, 'uniquely'), array(':field', ':value'))
			->rule('name', 'not_empty')
			->rule('name', 'max_length', array(':value', '200'))
			->rule('order', 'numeric')
			// Lavel
			->label('segment', __('Segment'))
			->label('name', __('Name'))
			->label('order', __('Order'))
		;

		return $validation;
	}

}