<?php
/**
 * @package   JTypeHints
 * @copyright Copyright (c) 2017 Nicholas K. Dionysopoulos
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

use Akeeba\JTypeHints\Command\Collect;
use Akeeba\JTypeHints\Command\Generate;
use Akeeba\JTypeHints\Command\Table;

// Has the user run composer install already?
if (!is_file(__DIR__ . '/vendor/autoload.php'))
{
	echo "\n\n\n";
	echo "* * *  E R R O R  * * *\n\n";
	echo "Please run composer install before running this application for the first time.\n";
	echo "If unsure, please take a look at the README.md file. Thank you!\n";
	echo "\n\n\n";
}

// Load Composer's autoloader
$loader = require_once __DIR__ . '/vendor/autoload.php';

// Load the version.php file
require_once 'version.php';

$app = new Silly\Application('TypeHint Helper for Joomla!', JTHH_VERSION);

$app
	->command('generate [folder] [--for-version=] [--for-site=]', new Generate())
	->descriptions(
		'Generates type hints for a specific Joomla! version or installed site',
		[
			'folder'        => 'Where do you want the typehint class files to be stored. Default: generated_hints',
			'--for-version' => 'Joomla! version number for which to generate the typehints',
			'--for-site'    => 'Path to a Joomla! installation for which to generate the typehints',
		]
	);
$app
	->command('collect for-version', new Collect())
	->descriptions(
		'Collects classmap statistics for a specific Joomla! version',
		[
			'for-version' => 'The Joomla! version to collect stats for',
		]
	);
$app
	->command('table [--format=]', new Table())
	->descriptions(
		'Create a classmap statistics table (remember to use --raw)',
		[
			'--format' => 'The format to generate (supported: markdown, page)',
		]
	)->defaults([
		'format' => 'markdown'
	]);

$app->run();