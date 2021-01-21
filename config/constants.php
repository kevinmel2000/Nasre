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
					'country_module',
					'occupation_module',
					'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'gfh_module',
                    'cedingbroker_module',
                    'felookup_module',
                    'city_module',
                    'state_module',
                    'eqz_module',
                    'fz_module',
                    'shiptype_module',
                    'classification_module',
                    'construction_module',
                    'marinelookup_module',
				],
	'CONTACT_TYPES' => ['Customer','Past-Customer','Non-Customer'],
	'PROSPECTS' => ['Prospect','Lost-Prospect','Non-Prospect'],
];
?>