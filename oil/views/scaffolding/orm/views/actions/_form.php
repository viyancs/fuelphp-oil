<?php echo "{% extends '/users/base_users.twig' %}\n" ?>
<?php echo "{% block title %}\n\t{{ title }}\n{% endblock %}\n\n" ?>
<?php echo "{% block css %}\n\t{{ parent() }}\n{% endblock %}\n\n" ?>
<?php echo "{% block content %}\n" ?>
<?php echo "{{ parent() }}\n\n" ?>

<?php echo "<!-- errors messages -->\n" ?>
<?php echo "\t{% if errors is defined %}\n" ?>
<?php echo "\t\t{% for key,err in errors %}\n" ?>
                <div class="alert alert-error">
                    <strong>Failure!</strong> <?php echo "{{err |replace({'&amp;':'&'})}}\n" ?>
                </div>
<?php echo "\t\t{% endfor %}\n" ?>
<?php echo "\t{% endif %}\n" ?>
<?php echo "<!-- end errors messages -->\n" ?>

<?php echo "{% autoescape false %}\n" ?>
<?php echo "{{ form_open() }}\n" ?>

    <fieldset>
        
        <?php echo "\t{{ form_input({'name' : 'csrf_code','class':'span4','type' :'hidden','value':csrf_token}) }}\n"; ?>
        
        <?php foreach ($fields as $field): ?>
            <div class="clearfix">
                <?php echo "{{ form_label('" . \Inflector::humanize($field['name']) . "','{$field['name']}') }}" ?>

                <div class="input">
                    <?php
                    switch ($field['type']):

                        case 'text':
                            echo "\t{{ form_textarea({'name' : '{$field['name']}','class':'span8','rows':'8','value':input.{$field['name']}}) }}\n";
                            break;

                        default:
                            echo "\t{{ form_input({'name' : '{$field['name']}','class':'span4','value':input.{$field['name']}}) }}\n";

                    endswitch;
                    ?>

                </div>
            </div>
        <?php endforeach; ?>
        <div class="actions">
            <?php echo "{{ form_submit({'name':'submit','type':'submit','value':'Save','class':'btn btn-primary'}) }}" ?>

        </div>
    </fieldset>

<?php echo "{{ form_close() }}" . "\n"; ?>
<?php echo "{% endautoescape %}" . "\n\n"; ?>
<p>
            <?php echo "{{html_anchor('$uri','Back') |raw }}"; ?> 
</p>
<?php echo "{% endblock %}" . "\n"; ?>

<?php echo "{% block script %}\n{{ parent() }}\n{% endblock %}" ."\n\n"; ?>
<?php echo "{% block footer %}\n{{parent()}}\n{% endblock %}" ."\n"; ?>
