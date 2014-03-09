<?php

class Application {
    private $name;
    private $language;
    private $version;
    private $user_config;
    private $author;
    private $website;
    
    private $db_adapter;
    private $controller;

    public function __construct($app_config_file) {
        require_once( $app_config_file);
        
        $this->name         = $app_config['name'];
        $this->version      = $app_config['version'];
        $this->author       = $app_config['author'];
        $this->website      = $app_config['website'];

        $this->user_config  = CONFIG_FILE;
    }
    
    public function bootstrap() {
        echo '<h3>Testing App requierments ... </h3>';
        
        try {
            // Check config file exist and is readable
            FileConfig::open( CONFIG_FILE );

            if( !is_readable($this->user_config))
                throw new Exception("The configuration file is missing or not readable");
                
            // Check template cache is writable by Apache
            if( !is_writable( VIEW_CACHE_DIR ) )
                throw new Exception("The template cache folder <b>" . VIEW_CACHE_DIR . "</b> must be writable by Apache user");

            // Check if language have been defined in config file
            $this->language = FileConfig::get_Value( 'language' );
			
            if( !$this->language )
				throw new Exception("Language configuration problem");
			
			// Check if at least one catalog is defined
			if( count(FileConfig::get_Catalogs()) == 0) {
				throw new Exception("Please define at least on Bacula director connection");
			}
            
        }catch( Exception $e ) {
            CErrorHandler::displayError($e);
        }
        
    }
    
    public function run() {
        /*
        echo '<h3>Application '.$this->name.' version '.$this->version;
        echo '(author '.$this->author.')';
        echo ' successfully started</h3><br />';
        echo '<a target="_blank" href="'.$this->website.'">Web site</a>';
        */
        
        /* TO DO
         * Simplify File and FileConfig classes (merge if necessary)
         * Modify CException::raiseErrors (should not die, use template in test page)
         * USER $SESSION $GET $POST should be manager by one object, remove redundancy in all the code
        */
        
        
        try {
            echo "<h3>Ready to run the app ... </h3>";
        }catch (Exception $e) {
            CErrorHandler::displayError($e);
        }
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getVersion() {
        return $this->version;
    }
    
    public function getAuthor() {
        return $this->author;
    }
}


?>