		$data = array();
                $data['<?php echo $singular_name ?>'] = Model_<?php echo $model_name ?>::find($id);

		if(is_null($id)) Response::redirect('<?php echo strtolower($singular_name) ?>');

                $data['title'] = "<?php echo ucfirst($singular_name) ?>";
                return Response::forge(View::forge('<?php echo $view_path ?>/view.twig', $data));
		
