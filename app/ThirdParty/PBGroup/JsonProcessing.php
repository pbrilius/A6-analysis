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

	public function __construct(array $labels, array $datasets)
	{
		$this->labels   = $labels;
		$this->datasets = $datasets;
	}

	public function datasetsFormatting()
	{
	}

	public function labelsFormatting()
	{
	}
}
