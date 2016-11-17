<?php

class Http
{
	private $requestMethod;

	private $requestPath;


	public function __construct()
	{
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];

		if(isset($_SERVER['PATH_INFO']) == false || $_SERVER['PATH_INFO'] == '/')
		{
			$this->requestPath = null;
		}
		else
		{
			$this->requestPath = strtolower($_SERVER['PATH_INFO']);
		}
	}

	public function getRequestFile()
	{
		if($this->requestPath == null)
		{
			return 'Home';
		}
		else
		{
			$pathSegments = explode('/', $this->requestPath);

			if(($pathSegment = array_pop($pathSegments)) == null)
			{
				// A trailing slash was added to the URL, remove it.
				$pathSegment = array_pop($pathSegments);
			}

			return ucfirst($pathSegment);
		}
	}

	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	public function getRequestPath()
	{
		return $this->requestPath;
	}

	public function redirectTo($url)
	{
		if(substr($url, 0, 1) !== '/')
		{
			$url = "/$url";
		}

		header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'].$url);
		exit();
	}

	public function sendJsonResponse($data)
	{
		exit(json_encode($data));
	}
}