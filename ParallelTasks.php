<?php



class ParallelTasks extends \Core_Daemon
{
    protected  $loop_interval = 5;

    /**
     * The only plugin we're using is a simple file-based lock to prevent 2 instances from running
     */
	protected function setup_plugins()
	{
        $this->plugin('Lock_File');
	}
	
	/**
	 * This is where you implement any once-per-execution setup code. 
	 * @return void
	 * @throws \Exception
	 */
	protected function setup()
	{

	}
	
	/**
	 * This is where you implement the tasks you want your daemon to perform. 
	 * This method is called at the frequency defined by loop_interval. 
	 *
	 * @return void
	 */
	protected function execute()
	{
        $m = new \Mongo();
		$posts = $m->tampon->posts->find();
		
		foreach ($posts as $post) {
			
			$this->log("Processing item");
			
			$this->task(new BigTask($post));
		}
	}

	

	/**
	 * Dynamically build the file name for the log file. This simple algorithm 
	 * will rotate the logs once per day and try to keep them in a central /var/log location. 
	 * @return string
	 */
	protected function log_file()
	{	
		$dir = '/var/log/daemons/paralleltasks';
		if (@file_exists($dir) == false)
			@mkdir($dir, 0777, true);
		
		if (@is_writable($dir) == false)
			$dir = BASE_PATH . '/example_logs';
		
		return $dir . '/log_' . date('Ymd');
	}
}
