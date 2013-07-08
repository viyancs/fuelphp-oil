<?php echo '<?php' ?>

class Model_<?php echo $model_name; ?> extends \Orm\Model
{
	protected static $_properties = array(
		'id',
<?php foreach ($fields as $field): ?>
		'<?php echo $field['name']; ?>',
<?php endforeach; ?>
<?php if ($include_timestamps): ?>
		'created_at',
		'updated_at',
<?php endif; ?>
	);
        
protected static $_table_name = '<?php $model = explode("_", $model_name); if (!empty($model[1])) { echo strtolower($model[1]);} else { echo strtolower($model_name); }?>';

<?php if ($include_timestamps): ?>
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);
<?php endif; ?>
}
