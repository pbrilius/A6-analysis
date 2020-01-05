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
		$tracks          = $this->tracks;
		$extractedLabels = [];
		foreach ($tracks as $track)
		{
			$extractedLabels[] = $track['track']['label'];
		}

		return $extractedLabels;
	}

	public function extractMarkets()
	{
		$tracks           = $this->tracks;
		$extractedMarkets = [];

		$dataset       = new \stdClass();
		$dataset->data = [];
		foreach ($tracks as $track)
		{
			$dataset->data[] = sizeof($trakc['track']['markets']);
		}

		$extractedMarkets = [
			$dataset,
		];

		return $extractedMarkets;
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
