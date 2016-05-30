<?php

namespace Craft;

class DevImages_ColorsService extends BaseApplicationComponent
{
	const HEX = 'hex';
	const RGB = 'rgb';

	function getRandomColorPair($type = 'hex')
	{
		$bgColors = $this->getBgColors();
		$fgColors = $this->getFgColors();
		$index = rand(0, count($bgColors) - 1);

		$bgColor = $type === self::RGB ? $this->hex2rgb($bgColors[$index]) : $bgColors[$index];
		$fgColor = $type === self::RGB ? $this->hex2rgb($fgColors[$index]) : $fgColors[$index];

		return [$bgColor, $fgColor];
	}

	function getBgColors()
	{
		return [
			'#F44336',
			'#E91E63',
			'#9C27B0',
			'#673AB7',
			'#3F51B5',
			'#2196F3',
			'#03A9F4',
			'#00BCD4',
			'#009688',
			'#4CAF50',
			'#8BC34A',
			'#CDDC39',
			'#FFEB3B',
			'#FFC107',
			'#FF9800',
			'#FF5722',
			'#795548',
			'#9E9E9E',
			'#607D8B',
		];
	}

	function getFgColors()
	{
		return [
			'#E53935',
			'#D81B60',
			'#8E24AA',
			'#5E35B1',
			'#3949AB',
			'#1E88E5',
			'#039BE5',
			'#00ACC1',
			'#00897B',
			'#43A047',
			'#7CB342',
			'#C0CA33',
			'#FDD835',
			'#FFB300',
			'#FB8C00',
			'#F4511E',
			'#6D4C41',
			'#757575',
			'#546E7A',
		];
	}

	protected function hex2rgb($hex)
	{
		$hex = trim($hex, '#');
		return [
			hexdec(substr($hex, 0, 2)),
			hexdec(substr($hex, 2, 2)),
			hexdec(substr($hex, 4, 2)),
		];
	}
}
