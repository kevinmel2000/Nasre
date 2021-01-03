<?php
return [
	// whenever you add a new module name in the MODULES array, remember to add its functionality in the 
	// PermissionsController index, permissionsByUser and getPermissionsByUser methods
	// and respective middleware route in the routes.  
	'MODULES'=>[
					'contact_module', 
					'role_module', 
					'user_module', 
					'lead_module', 
					'product_module', 
					'office_module',
				],
	'CONTACT_TYPES' => ['Customer','Past-Customer','Non-Customer'],
	'PROSPECTS' => ['Prospect','Lost-Prospect','Non-Prospect'],
];
?>