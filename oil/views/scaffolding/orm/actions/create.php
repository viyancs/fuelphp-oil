                $data = array();
                $data['csrf_token'] = \Security::fetch_token();

                //handling session message
                $errors = Session::get_flash('errors');
                $success = Session::get_flash('success');
                $input = Session::get_flash('input');

                if(isset($errors)) {
                    $data['errors'] = $errors;
                }

                if(isset($success)) {
                    $data['success'] = $success; 
                }

                if(isset($input)) {
                    $data['input'] = $input; 
                }



                //checking method
                if (Input::method() == 'GET') {
                    $data['title'] = '<?php echo \Str::ucwords($plural_name); ?>';
                    return Response::forge(View::forge('<?php echo $view_path ?>/_form.twig', $data));
                }

                //validation
                $val = Validation::forge('create_<?php echo $view_path ?>');
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
                    Response::redirect('<?php echo $view_path ?>/create');
                }


                //check if validation not valid
                if (!$val->run()) {
                    Session::set_flash('errors', $val->error());
                    Session::set_flash('input', $val->input());
                    Response::redirect('<?php echo $view_path ?>/create');

                }

                $<?php echo $singular_name; ?> = new Model_<?php echo $model_name; ?>();
<?php foreach ($fields as $field): ?>
                $<?php echo $singular_name; ?>-><?php echo $field['name']; ?> = $val->validated('<?php echo $field['name']; ?>');
<?php endforeach; ?>
                
                if ($<?php echo $singular_name; ?>->save()) {
                    Session::set_flash('success', 'Added <?php echo $singular_name; ?> #' . $<?php echo $singular_name; ?>->id . '.');
                    Response::redirect('<?php echo $view_path ?>');
                } 

                else {
                    Session::set_flash('errors', array('save'=>'Could not save <?php echo $singular_name; ?>.'));
                }
