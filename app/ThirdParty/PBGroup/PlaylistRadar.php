<?php

namespace A6\ThirdParty\PBGroup;

class PlaylistRadar
{
	/**
	 * Tracks list
	 *
	 * @var array
	 */
	private $tracks;

	public function extractLabels()
	{
	}

	public function extractMarkets()
	{
	}

	/**
	 * Set tracks
	 *
	 * @param  array $tracks
	 * @return self
	 */
	public function setTracks(array $tracks)
	{
		$this->tracks = $tracks;

		return $this;
	}
}
