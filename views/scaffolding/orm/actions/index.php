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
                        'pagination_url' => Uri::base() .'<?php echo $uri; ?>',
                        'total_items' => $data['total_<?php echo strtolower($plural_name) ?>'],
                        'per_page' => 2,
                        'uri_segment' => count(Input::uri()) + 1,
                        'template' => array(

                            'wrapper_start' => '<ul> ',
                            'wrapper_end' => ' </ul>',
                            'active_start'            => ' <li class="active">',
                            'active_end'              => ' </li>',
                            'previous_inactive_start' => ' <li class="disabled">',
                            'previous_inactive_end'   => ' </li>',
                            'next_inactive_start'     => ' <li class="disabled">',
                            'next_inactive_end'       => ' </li>',
                            'page_start'              => ' <li class="page-link"> ',
                            'page_end'                => ' </li>',
                            'next_start'              => ' <li> ',
                            'next_end'                => ' </li>',
                            'previous_start'          => ' <li> ',
                            'previous_end'            => ' </li>',
                            'regular_start'           => ' <li>',
                            'regular_end'             => ' </li>',
                            
                            ),
                        );
                
                // set config pagination
                Pagination::set_config($config);
                
		$data['<?php echo strtolower($plural_name) ?>'] = Model_<?php echo $model_name; ?>::query()
                        ->order_by('created_at', 'DESC')
                        ->offset(Pagination::get('offset'))
                        ->limit(Pagination::get('per_page'))
                        ->get();
                
                $data['pagination'] = Pagination::create_links();
                return Response::forge(View::forge('<?php echo $view_path ?>/index.twig', $data));