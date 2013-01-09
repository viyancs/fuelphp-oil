
<?php echo "{% extends '/users/base_users.twig' %}\n" ?>
<?php echo "{% block title %}\n\t{{ title }}\n{% endblock %}\n\n" ?>
<?php echo "{% block css %}\n\t{{ parent() }}\n{% endblock %}\n\n" ?>
<?php echo "{% block content %}\n" ?>
<?php echo "{{ parent() }}\n\n" ?>


<div class="row-fluid">
    <div class="span12">
        <h2>Viewing #<?php echo "{{". $singular_name  .".id }}" ?></h2>
<?php foreach ($fields as $field): ?>
        <p>
            <strong><?php echo ucfirst($field['name']) ?></strong>
            <?php echo "{{".$singular_name .".{$field['name']}}}"; ?>
        </p>
<?php endforeach; ?>

        <a href="/<?php echo $uri ?>/edit/<?php echo "{{". $singular_name  .".id }}" ?>">Edit</a> |
        <a href="/<?php echo $uri ?>">Back</a>                
    </div>
</div>


<?php echo "{% endblock %}" . "\n"; ?>

<?php echo "{% block script %}\n{{ parent() }}\n{% endblock %}" ."\n\n"; ?>
<?php echo "{% block footer %}\n{{parent()}}\n{% endblock %}" ."\n"; ?>

