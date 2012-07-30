<?php



/**
 * Demonstrate using a Core_ITask object to create a more complex task
 * This won't actually do anything but you get the idea
 *
 * @author Shane Harter
 * @todo Create a plausible demo of a complex task that implements \Core_ITask
 */
class BigTask implements \Core_ITask
{
    /**
     * A handle to the Daemon object
     * @var \Core_Daemon
     */
    private $daemon = null;

    private $post;

    public function __construct($post) {
        $this->post = $post;
    }

    /**
     * Called on Construct or Init
     * @return void
     */
    public function setup()
    {
        $this->daemon = ParallelTasks::getInstance();
    }

    /**
     * Called on Destruct
     * @return void
     */
    public function teardown()
    {
        // Satisfy Interface
    }

    /**
     * This is called after setup() returns
     * @return void
     */
    public function start()
    {
       $this->daemon->log("Removed Mongo item...");
       
       $m = new \Mongo();
       $m->tampon->posts->remove(array('_id' => $this->post['_id']));
       
    }
}
