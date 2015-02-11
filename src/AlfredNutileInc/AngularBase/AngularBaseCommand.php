<?php namespace AlfredNutileInc\AngularBase;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AngularBaseCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'angular:base-resource';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pass in the resource name eg project and this will setup a folder with the needed files to get going.';
	private $resource_name;
	protected $base_folder_with_resource_name;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//Set to not plural
		//Get Resource Name
		$this->resource_name = $this->argument('resource_name');
		$this->setBaseFolderWithResourceName($this->baseFolder() . '/' . $this->resource_name);
		//Make it valid eg lower case no spaces etc
		//Use for making folder
		$this->makeFolder();
		//Make Files
		// config.js
		$this->make('config.txt', 'config.js');
		// service.js
		$this->make('service.txt', 'service.js');
		// indexController.js
		// templates
		// templates/index.html
		// templates/create_edit.html
		//Finally output the html needed for the main layout
	}

	public function make($stub, $output_name)
	{
		$content = $this->getFile($stub);
		$content = $this->replaceTokens($content);
		File::put($this->getBaseFolderWithResourceName() . '/' . $output_name, $content);
	}


	public function getFile($file)
	{
		return File::get(__DIR__ . '/stubs/' . $file);
	}

	public function replaceTokens($content)
	{
		$lower_name = $this->getLowerCaseName();
		$upper_name = $this->getUpperCaseName();
		return str_replace(
			['$RESOURCE_LOWER', '$RESOURCE_UPPER'],
			[$lower_name, $upper_name],
			$content
		);
	}

	public function getUpperCaseName()
	{
		return ucfirst($this->resource_name);
	}

	public function getLowerCaseName()
	{
		return strtolower($this->resource_name);
	}

	public function makeFolder()
	{
		if(File::exists($this->baseFolder() . '/' . $this->resource_name))
		{
			$this->error(sprintf("Folder already exists %s", $this->baseFolder() . '/' . $this->getLowerCaseName()));
		} else {
			File::makeDirectory($this->baseFolder() . '/' . $this->resource_name, $mode = 0755, $recursive = true, $force = false);
		}
	}

	public function baseFolder()
	{
		$path = base_path() . '/' . Config::get('angular-base::config.default_path');
		return $path;
	}

	/**
	 * @return mixed
	 */
	public function getBaseFolderWithResourceName()
	{
		return $this->base_folder_with_resource_name;
	}

	/**
	 * @param mixed $base_folder_with_resource_name
	 */
	public function setBaseFolderWithResourceName($base_folder_with_resource_name)
	{
		$this->base_folder_with_resource_name = $base_folder_with_resource_name;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('resource_name', InputArgument::REQUIRED, 'For example project'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(

		);
	}

}
