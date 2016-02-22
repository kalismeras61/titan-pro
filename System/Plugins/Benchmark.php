<?php
namespace Titan\Plugins;

/**
 * Benchmark Plugin
 *
 * @package Titan\Plugins
 */

class Benchmark
{
    private $flag_time;

    /**
     * Get current microtime
     * @return double
     */
    private function get_time() {
        $timer = explode( ' ', microtime() );
        $timer = $timer[1] + $timer[0];
        return $timer;
    }

    /**
     * Marh a flag for benchmark
     * @param 	string 	$name
     * @return 	void
     */
    public function flag($name)
    {
        $this->flag_time[$name] = $this->get_time();
    }

    /**
     * Get speed benchmark value
     * @param 	string 	$basla
     * @param 	string 	$bitir
     * @return 	double
     */
    public function elapsed_time($basla, $bitir)
    {
        return round($this->flag_time[$bitir] - $this->flag_time[$basla], 6);
    }

    /**
     * Get memory usage as KB
     * @return 	string
     */
    public function memory_usage()
    {
        return round(memory_get_usage()/1024,2) . ' Kb';
    }

    /**
     * Get max memory usage as KB
     * @return 	string
     */
    public function memory_max_usage()
    {
        return round(memory_get_peak_usage()/1024,2) . ' Kb';
    }

}