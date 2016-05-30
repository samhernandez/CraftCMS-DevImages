<?php

namespace Craft;

class DevImages_ImageService extends BaseApplicationComponent
{
	/**
	 * Creates and saves an image if its extension is valid.
	 * @param  int    $width   Pixel width
	 * @param  int    $height  Pixel height
	 * @param  string $path    File path to save to
	 */
	public function createAndSave($width, $height, $path)
	{
		$ext = strtolower(IOHelper::getExtension($path));

		// Imagine only supports these files except 'svg' which is
		// supported by this class.
		if ( ! in_array($ext, ['gif', 'jpg', 'jpeg', 'png', 'wbmp', 'xbm', 'svg'])) {
			return;
		}

		return $ext === 'svg' ?
			$this->createAndSaveSvg($width, $height, $path) :
			$this->createAndSaveImage($width, $height, $path);
	}

	/**
	 * Creates and saves a non-svg image.
	 * @param  int    $width   Pixel width
	 * @param  int    $height  Pixel height
	 * @param  string $path    File path to save to
	 */
	public function createAndSaveImage($width, $height, $path)
	{
		$colorPair = craft()->devImages_colors->getRandomColorPair(DevImages_ColorsService::RGB);
		$imagine = $this->getImagineInstance();
		$palette = new \Imagine\Image\Palette\RGB();
		$box = new \Imagine\Image\Box($width, $height);

		// Create the image with background color
		// Must be 100 for png, 0 for gif. Dunno why.
		$opacity = IOHelper::getExtension($path) === 'gif' ? 0 : 100;
		$image = $imagine->create($box, $palette->color($colorPair[0], $opacity));

		// Draw an X on the image with the foreground color
		$point1 = new \Imagine\Image\Point(0, 0);
		$point2 = new \Imagine\Image\Point($width, $height);
		$point3 = new \Imagine\Image\Point(0, $height);
		$point4 = new \Imagine\Image\Point($width, 0);

		$image->draw()->line($point1, $point2, $palette->color($colorPair[1], 0), 4);
		$image->draw()->line($point3, $point4, $palette->color($colorPair[1], 0), 4);

		$image->save($path);
	}

	/**
	 * Creates and saves an svg image.
	 * @param  int    $width   Pixel width
	 * @param  int    $height  Pixel height
	 * @param  string $path    File path to save to
	 */
	public function createAndSaveSvg($width, $height, $path)
	{
		$colorPair = craft()->devImages_colors->getRandomColorPair(DevImages_ColorsService::HEX);
		$contents = craft()->templates->render('devimages/_svg', [
			'bg' => $colorPair[0],
			'fg' => $colorPair[1],
			'height' => $height,
			'width'  => $width,
		]);

		IOHelper::writeToFile($path, $contents);
	}

	/**
	 * Returns the appropriate instance of `Imagine` class.
	 * @return Imagine
	 */
	protected function getImagineInstance()
	{
		return craft()->images->isGd() ?
			new \Imagine\Gd\Imagine() :
			new \Imagine\Imagick\Imagine();
	}
}
