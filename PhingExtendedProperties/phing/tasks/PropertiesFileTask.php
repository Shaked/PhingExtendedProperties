<?php
/**
 * Require PropertyTask to extend it 
 */
include_once '/usr/share/pear/phing/tasks/system/PropertyTask.php';
/**
 * Use PropertiesFile instead of Properties class 
 */
include_once 'PropertiesFile.php';
/**
 * 
 * PropertiesFileTask is a class which extends the behavior of PropertyTask 
 * 	So when loading an .properties you would be able to extend it from other 
 * 		.properties files as well
 * @author Shaked
 *
 */
class PropertiesFileTask extends PropertyTask { 
    /**
     * load properties from a file.
     * @param PhingFile $file
     */
    protected function loadFile(PhingFile $file) {
        $props = new PropertiesFile();
        $this->log("Loading ". $file->getAbsolutePath(), Project::MSG_INFO); 
        try { // try to load file
            if ($file->exists()) {
                $props->load($file); 
                $this->addProperties($props);
            } else {
                $this->log("Unable to find property file: ". $file->getAbsolutePath() ."... skipped", Project::MSG_WARN);
            }
        } catch (IOException $ioe) {
            throw new BuildException("Could not load properties from file.", $ioe);
        }
    }
    /**
     * (non-PHPdoc)
     * @see PropertyTask::main()
     */
	 public function main() {
	 	if (!$this->file){
	 		throw new PropertiesFileTaskException('File property is required'); 
	 	}
	 	parent::main(); 
	 }
}
/** 
 * @author Shaked 
 */
class PropertiesFileTaskException extends Exception {} 