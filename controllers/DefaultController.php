<?php

class Default_Controller {

	protected $templateNotAllowed = "template-not-allowed.php";

	public function __construct() {

	}
    
    public function indexAction($template) {
        return $template;
    }

	protected function getTemplateNotAllowed() {
		return get_template_directory() . DIRECTORY_SEPARATOR . $this->templateNotAllowed;
	}

	protected function getTemplate($template) {
		return get_template_directory() . DIRECTORY_SEPARATOR . $template;
	}

}
