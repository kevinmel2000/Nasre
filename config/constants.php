<?php
return [
	// whenever you add a new module name in the MODULES array, remember to add its functionality in the 
	// PermissionsController index, permissionsByUser and getPermissionsByUser methods
	// and respective middleware route in the routes.  
	'MODULES'=>[
					'contact_module', 
					'role_module', 
					'user_module', 
					// 'lead_module', 
					// 'product_module', 
					// 'office_module',
					'country_module',
					'occupation_module',
					'cob_module',
                    'currency_module',
                    'exchange_module',
                    'koc_module',
                    'golf_field_hole_module',
                    'ceding_broker_module',
                    'lookup_location_module',
                    'city_module',
                    'state_module',
                    'earthquake_zone_module',
                    'flood_zone_module',
                    'ship_type_module',
                    'classification_module',
                    'construction_module',
					'marine_lookup_module',
					'property_type_module',
					'condition_needed_module',
				],
	'MODULES2'=>['fire_engineering_slip_module',
					'financial_lines_slip_module',
                    'marine_slip_module',
                    'personal_accident_slip_module',
                    'hole_in_one_slip_module',
                    'he_and_motor_slip_module',
                    'moveable_property_slip_module',
				],
	'CONTACT_TYPES' => ['Customer','Past-Customer','Non-Customer'],
	'PROSPECTS' => ['Prospect','Lost-Prospect','Non-Prospect'],
];
?>