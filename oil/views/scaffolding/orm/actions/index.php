                $data=array();
                
                //checking method
                if (Input::method() == 'POST') {
                    throw new HttpServerErrorException;
                }
                
                $success = Session::get_flash('success');
                
                if(isset($success)) {
                    $data['success'] = $success; 
                }

                
                $data['title'] = "<?php echo ucfirst($plural_name); ?>";
                $data['csrf_token'] = \Security::fetch_token();
                $data['total_<?php echo strtolower($plural_name) ?>'] = count(Model_<?php echo $model_name; ?>::find('all'));//total page
                $config = array(
                        'pagination_url' => '/<?php echo $uri; ?>',
                        'total_items' => $data['total_<?php echo strtolower($plural_name) ?>'],
                        'per_page' => 2,
                        'uri_segment' => count(Input::uri()) + 1,
                        'template' => array(

                            'previous_inactive_start' => ' <li class="disabled">',
                            'previous_inactive_end'   => ' </li>',
                            'next_inactive_start'     => ' <li class="disabled">',
                            'next_inactive_end'       => ' </li>',
                            ),
                        );
                
                // set config pagination
                Pagination::set_config($config);
                
		$data['<?php echo strtolower($plural_name) ?>'] = Model_<?php echo $model_name; ?>::find()
                        ->order_by('created_at', 'DESC')
                        ->rows_offset((int)(Pagination::$offset))
                        ->rows_limit(Pagination::$per_page)
                        ->get();
                
                $data['pagination'] = Pagination::create_links();
                return Response::forge(View::forge('<?php echo $view_path ?>/index.twig', $data));