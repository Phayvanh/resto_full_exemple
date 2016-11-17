<?php

class FrontController
{
	private $applicationPath;

	private $http;

    private $useAutoloadChain;

	private $viewData;


	public function __construct()
	{
		$this->applicationPath  = realpath(__DIR__.'/../application');
		$this->http             = new Http();
        $this->useAutoloadChain = null;
		$this->viewData         = [ 'template' => null, 'variables' => array() ];
	}

	public function buildContext()
	{
		// Install application classes autoloading.
		spl_autoload_register([ $this, 'loadClass' ]);

		// Load configuration files.
		$configuration = new Configuration();
		$configuration->load('database');
        $configuration->load('library');

        $this->useAutoloadChain = $configuration->get
        (
            'library', 'autoload-chain', false
        );
	}

	public function loadClass($class)
	{
        if(substr($class, -4) == 'Form')
        {
            $filename = $this->applicationPath."/forms/$class.class.php";
        }
		elseif(substr($class, -5) == 'Model')
		{
			$filename = $this->applicationPath."/models/$class.class.php";
		}
		else
		{
			$filename = $this->applicationPath."/classes/$class.class.php";
		}

		if(file_exists($filename) == true)
		{
            include $filename;
		}
        else
        {
            if($this->useAutoloadChain == false)
            {
                $this->renderErrorView
                (
                    "La classe <strong>$class</strong> ne se trouve pas ".
                    "dans le fichier <strong>$filename</strong>"
                );
            }
        }
	}

	private function renderErrorView($errorMessage)
	{
		include 'ErrorView.phtml';
		die();
	}

	public function renderView()
	{
		// Build the full template path and filename using defaults.
		$this->viewData['template'] = 
			$this->applicationPath.'/www'.$this->http->getRequestPath().'/'.
			$this->http->getRequestFile().'View.phtml';

		// Add special request URL view template variable.
		$this->viewData['variables']['requestUrl'] =
			str_replace('index.php', '', $_SERVER['SCRIPT_NAME']).'index.php';

		// Add special WWW URL view template variable.
		$this->viewData['variables']['wwwUrl'] =
			str_replace('index.php', '', $_SERVER['SCRIPT_NAME']).'application/www';

        // Did the controller create a form ?
        if(array_key_exists('_form', $this->viewData['variables']) == true)
        {
            if($this->viewData['variables']['_form'] instanceof Form)
            {
                // Yes, get the form object.

                /** @var Form $form */
                $form = $this->viewData['variables']['_form'];

                if($form->hasFormFields() == false)
                {
                    // The form has not yet been built.
                    $form->build();
                }

                // Merge the form fields with the template variables.
                $this->viewData['variables'] = array_merge
                (
                    $this->viewData['variables'],
                    $form->getFormFields()
                );

                // Add the form field error message template variable.
                $this->viewData['variables']['errorMessage'] = $form->getErrorMessage();
            }

            unset($this->viewData['variables']['_form']);
        }

		// Inject the view template variables before loading the template file.
		extract($this->viewData['variables'], EXTR_OVERWRITE);
		require $this->applicationPath.'/www/LayoutView.phtml';
	}

	public function run()
	{
		// First try to run the layout controller if there is one...
		$controllerName = 'LayoutController';
		$controllerPath = $this->applicationPath.'/controllers';
		if(file_exists("$controllerPath/$controllerName.class.php") == true)
		{
			$this->runPageController($controllerPath, $controllerName);
		}

		// ...Then figure out the page controller to run using the HTTP request path.
		$controllerName = $this->http->getRequestFile().'Controller';
		$controllerPath = $this->applicationPath.'/controllers'.$this->http->getRequestPath();

		$this->runPageController($controllerPath, $controllerName);
	}

	private function runPageController($controllerPath, $controllerName)
	{
		// Load the page controller class file.
		require "$controllerPath/$controllerName.class.php";

		// Create the page controller.
		$controller = new $controllerName();

		/*
		 * Select the page controller's HTTP GET or HTTP POST method to run
		 * and the HTTP data fields to give to the method.
		 */
		if($this->http->getRequestMethod() == 'GET')
		{
			$fields = $_GET;
			$method = 'httpGetMethod';
		}
		else
		{
			$fields = $_POST;
			$method = 'httpPostMethod';
		}

		if(method_exists($controller, $method) == false)
		{
			$this->renderErrorView
			(
				'Une requête HTTP '.$this->http->getRequestMethod().' a été effectuée, '.
				"mais vous avez oublié la méthode <strong>$method</strong> dans le contrôleur ".
				'<strong>'.get_class($controller).'</strong>'
			);
		}

		// Run the page controller method and merge all the controllers view variables together.
		$this->viewData['variables'] = array_merge
		(
			$this->viewData['variables'],
			(array) $controller->$method($this->http, $fields)
		);
	}
}