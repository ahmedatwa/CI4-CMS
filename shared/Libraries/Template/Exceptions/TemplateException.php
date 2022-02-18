<?php

namespace Shared\Libraries\Template\Exceptions;

use CodeIgniter\Exceptions\FrameworkException;

class TemplateException extends FrameworkException
{
	public static function forInvalidAdaptor(string $adaptor)
	{
		return new static('Error: Could not load template adaptor ' . $adaptor . '!');
	}
	public static function forFileNotFound(string $path)
	{
		return new static(lang('Files.fileNotFound', [$path]));
	}
	public static function forTemplateNotFound(string $path)
	{
		return new static('Unable to load template ' . $path . '!');
	}
	public static function forListNotFound(string $path)
	{
		return new static('Unable to find list array or language file in ' . $path . '!');
	}
}
