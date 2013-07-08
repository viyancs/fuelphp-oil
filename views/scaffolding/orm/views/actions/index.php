<?php echo "{% extends '/frontend/base_front.twig' %}\n" ?>
<?php echo "{% block title %}\n\t{{ title }}\n{% endblock %}\n\n" ?>
<?php echo "{% block css %}\n\t{{ parent() }}\n{% endblock %}\n\n" ?>
<?php echo "{% block content %}\n" ?>

<?php echo "<!-- errors messages -->\n" ?>
<?php echo "\t{% if success is defined %}\n" ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo "{{success |replace({'&amp;':'&'})}}\n" ?>
                </div>
<?php echo "\t{% endif %}\n" ?>
<?php echo "<!-- end errors messages -->\n" ?>

<?php echo "\t{{ form_input({'name' : 'csrf_code','class':'span4','id':'csrf_token','type' :'hidden','value':csrf_token}) | raw }}\n"; ?>
        
<div class="row-fluid">
    <div class="span12">
        <h2>Listing <?php echo \Str::ucfirst($plural_name); ?></h2>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
<?php foreach ($fields as $field): ?>
                    <th><?php echo \Inflector::humanize($field['name']); ?></th>
<?php endforeach; ?>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php echo "{% for list in ". strtolower(\Str::ucfirst($plural_name)) ." %}\n" ?>
                <tr id="{{list.id}}" name="{{list.name}}">
<?php foreach ($fields as $field): ?>
                    <td><?php echo "{{list.{$field['name']}}}"; ?></td>
<?php endforeach; ?>
                    <td>
                        <a href="{{base_url()}}<?php echo $uri ?>/view/{{list.id}}" rel="tooltip" title="View" ><i class="icon-eye-open"></i></a> |
                        <a href="{{base_url()}}<?php echo $uri ?>/edit/{{list.id}}" rel="tooltip" title="Edit"><i class="icon-edit"></i></a> |
                        <a href="javascript:;" class="delete" rel="tooltip" title="delete" ><i class="icon-remove"></i></a>
                    </td>
                </tr>
                
                <?php echo "{% endfor %}" ?>
            </tbody>
        </table>
        <p>
            <a class="btn btn-success" href="{{base_url()}}<?php echo $uri ?>/create">Add new <?php echo \Str::ucfirst($singular_name); ?></a>
        </p>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php echo "{{ pagination |raw }}\n"?>
    </div>
</div>

<div id="dialog-<?php echo $uri ?>" style="display:none">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

<?php echo "{% endblock %}" . "\n"; ?>

<?php echo "{% block js %}\n"; ?>
<?php echo "{{ parent() }}\n"; ?>
<script>
    $(function(){
        
        //delete using ajax
        $(".delete").click(function(e){
            openDialogDelete($(this));
            e.preventDefault();
            
        });
        
        //open dialog delete
        function openDialogDelete(el) {
            var id = el.parent().parent().attr("id");
            var name = el.parent().parent().attr("name");
            var csrf_code = $("#csrf_token").val();
            
            $( "#dialog-<?php echo $uri ?>" ).dialog({
                resizable: false,
                height:"auto",
                open: function( event, ui ) {
                    $(this).parent().find(".ui-dialog-titlebar > .ui-dialog-title" ).text("Delete Monkey with name is " + name);
                },
                modal: true,
                buttons: {
                    "Delete": function() {
                        
                        $.ajax({
                            type: "POST",
                            url: "{{base_url()}}<?php echo $uri ?>/delete/" + id,
                            data: { csrf_code: csrf_code},
                            success: function(data) {
                                window.location.replace(data);
                            }
                        });
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
         }
         
         //tooltip
         $("[rel=tooltip]").tooltip();
        
    });
</script>
<?php echo "{% endblock %}" ."\n\n"; ?>

<?php echo "{% block footer %}\n{{parent()}}\n{% endblock %}" ."\n"; ?>

