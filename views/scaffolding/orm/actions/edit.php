		$data = array();
                $data['title'] = 'Edit <?php echo ucfirst($singular_name); ?>';
                $data['csrf_token'] = \Security::fetch_token();
                
                //handling session message
                $errors = Session::get_flash('errors');
                $input = Session::get_flash('input');
                if(isset($errors)) {
                    $data['errors'] = $errors;
                }
                
                //validate id
                $id = intval($id);
                if(intval($id) === 0) Response::redirect('<?php echo $uri; ?>');
         
                //find <?php echo $singular_name."\n"; ?>
                $<?php echo $singular_name; ?> = Model_<?php echo $model_name; ?>::find($id);
                
                if(empty($<?php echo $singular_name; ?>)) Response::redirect('<?php echo $uri; ?>');
                               
                if(Input::method() === 'GET') {
                    
                    if(isset($input)) {
                        $input['id'] = $id;
                        $data['input'] = $input; 
                    }
                    
                    else {
                        $data['input'] = $<?php echo $singular_name; ?>;
                    
                    }
                    
                    return Response::forge(View::forge('<?php echo $view_path; ?>/edit.twig', $data));
                                        
                }
                
                //validate update <?php echo $singular_name ."\n"; ?>
               	$val = Validation::forge('edit_<?php echo $singular_name; ?>');
<?php foreach ($fields as $field): ?>
                $val->add('<?php echo $field['name']; ?>', '<?php echo ucfirst($field['name']); ?>')
                    ->add_rule('required')
                    ->add_rule('trim')
                    ->add_rule('valid_string',array())
                    ->add_rule('min_length', 6)
                    ->add_rule('max_length', 45);
<?php endforeach; ?>
                
                //checking csrf
                if (\Security::check_token(Input::post('csrf_code')) !== true) {
                    Response::redirect('<?php echo $uri; ?>/edit/'.$id);
                }
               
                if(!$val->run()) {
                    
                    Session::set_flash('errors', $val->error());
                    Session::set_flash('input', $val->input());
                    Response::redirect('<?php echo $uri; ?>/edit/'.$id);
                }
                
<?php foreach ($fields as $field): ?>
                $<?php echo $singular_name; ?>-><?php echo $field['name']; ?> = $val->validated('<?php echo $field['name']; ?>');
<?php endforeach; ?>
                
                if ($<?php echo $singular_name; ?>->save()) {
                    
                    Session::set_flash('success', 'Updated <?php echo $singular_name; ?> #' . $id);
                    Response::redirect('<?php echo $uri; ?>');
                    
                } 
                
                else {
                    Session::set_flash('errors', array('update'=>'Could not update <?php echo $singular_name; ?> #') . $id);
                }

                
                