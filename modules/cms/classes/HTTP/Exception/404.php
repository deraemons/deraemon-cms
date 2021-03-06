<?php

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {

	/**
	 * Generate a Response for the 404 Exception.
	 *
	 * Page Not Found
	 * The user should be shown a nice 404 page.
	 *
	 * @return Response
	 */
	public function get_response()
	{
		// Lets log the Exception, Just in case it's important!
		Kohana_Exception::log($this);

		if (Kohana::$environment >= Kohana::DEVELOPMENT)
		{
			// Show the normal Kohana error page.
			return parent::get_response();
		}
		else
		{
			// Get tpl directory
			$front_tpl_dir = Cms_Helper::settings('front_tpl_dir');

			// Get file
			$content_file = Tpl::get_file($this->code, $front_tpl_dir.'/error');

			// Todo:: 「,」「.」とか入るときはカレントRULとれないから。
			$request_url = $this->request()->current() ? $this->request()->current()->uri() : __('not know');

			// Set variable and render
			$content = Tpl::factory($content_file)
				->set('code', $this->getCode())
				->set('message', $this->getMessage())
				->set('request_url', $request_url)
				->render();

			// Factory response
			$response = Response::factory();
			$response->body($content);

			return $response;
		}
	}

}