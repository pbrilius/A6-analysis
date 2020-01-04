<?php

namespace A6\Entities;

use CodeIgniter\Entity;

class Track extends Entity
{
	protected $attributes = [
		'id'         => null,
		'spotifyId'  => null,
		'data'       => null,
		'created_at' => null,
		'updated_at' => null,
		'deleted_at' => null,
	];

	protected $casts = [
		'data' => 'json',
	];

	public function setCreatedAt(string $dateString)
	{
		$this->attributes['created_at'] = new Time($dateString, 'UTC');

		return $this;
	}

	public function getCreatedAt(string $format = 'Y-m-d H:i:s')
	{
		$this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);

		$timezone = $this->timezone ?? app_timezone();

		$this->attributes['created_at']->setTimezone($timezone);

		return $this->attributes['created_at']->format($format);
	}

	public function setUpdatedAt(string $dateString)
	{
		$this->attributes['updated_at'] = new Time($dateString, 'UTC');

		return $this;
	}

	public function getUpdatedAt(string $format = 'Y-m-d H:i:s')
	{
		$this->attributes['updated_at'] = $this->mutateDate($this->attributes['updated_at']);

		$timezone = $this->timezone ?? app_timezone();

		$this->attributes['updated_at']->setTimezone($timezone);

		return $this->attributes['updated_at']->format($format);
	}

	public function setDeletedAt(string $dateString)
	{
		$this->attributes['deleted_at'] = new Time($dateString, 'UTC');

		return $this;
	}

	public function getDeletedAt(string $format = 'Y-m-d H:i:s')
	{
		$this->attributes['deleted_at'] = $this->mutateDate($this->attributes['deleted_at']);

		$timezone = $this->timezone ?? app_timezone();

		$this->attributes['deleted_at']->setTimezone($timezone);

		return $this->attributes['deleted_at']->format($format);
	}
}
