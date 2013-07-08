		if(Input::method() !== "POST") Response::redirect('<?php echo $uri; ?>');
                
                //validate id
                $id = intval($id);
                if(intval($id) === 0) Response::redirect('<?php echo $uri; ?>');
                
                //checking csrf
                if (\Security::check_token(Input::post('csrf_code')) !== true) {
                    throw new HttpServerErrorException;
                }
                
		if ($<?php echo $singular_name; ?> = Model_<?php echo $model_name; ?>::find($id)) {
			$<?php echo $singular_name; ?>->delete();

			Session::set_flash('success', 'Deleted <?php echo $singular_name; ?> #'.$id);
		}

		else {
			Session::set_flash('error', 'Could not delete <?php echo $singular_name; ?> #'.$id);
		}

		return new Response(Uri::base() . "<?php echo $uri; ?>");
