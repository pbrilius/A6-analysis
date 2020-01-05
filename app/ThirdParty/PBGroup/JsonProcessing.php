<?php

namespace A6\ThirdParty\PBGroup;

class JsonProcessing
{
	/**
	 * Labels
	 *
	 * @var array
	 */
	private $labels = [];

	/**
	 * Datasets
	 *
	 * @var array
	 */
	private $datasets = [];

	public function datasetsFormatting()
	{
		return json_encode($this->datasets);
	}

	public function labelsFormatting()
	{
		return json_encode($this->labels);
	}

	/**
	 * Set labels
	 *
	 * @param  array $labels
	 * @return self
	 */
	public function setLabels(array $labels)
	{
		$this->labels = $labels;

		return $this;
	}

	/**
	 * Set datasets
	 *
	 * @param  array $datasets
	 * @return self
	 */
	public function setDatasets(array $datasets)
	{
		$this->datasets = $datasets;

		return $this;
	}
}
